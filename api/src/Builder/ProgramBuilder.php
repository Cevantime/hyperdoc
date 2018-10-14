<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 18:13
 */

namespace App\Builder;

use App\Entity\Program;
use App\Entity\ProgramAssociation;
use App\Entity\ProgramValue;
use App\Entity\ValueInjection;
use App\Repository\ProgramRepository;
use App\Service\FullCodeGenerator;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Expr\Value;
use Middlewares\HttpErrorException;
use Sherpa\Rest\Utils\Bag;
use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Rest\Builder\RestBuilderInterface;
use Sherpa\Rest\Validator\InputBag;

class ProgramBuilder implements RestBuilderInterface
{
    // [[ma_valeur]]
    const VAR_REGEX = '/\\[\\[([a-zA-Z0-9_]+)\\]\\]/';

    // [%mon-program:mon_input(ma_valeur):mon_autre_input(mon_autre_valeur)%]
    const PROGRAM_REGEX = '/\\[\\%(.+?)\\%\\]/';

    protected $valueBuilder;
    protected $codeGenerator;
    protected $programRepo;
    protected $locale;

    public function __construct(ProgramValueBuilder $valueBuilder, ProgramRepository $programRepo, ServerRequestInterface $request, FullCodeGenerator $codeGenerator)
    {
        $this->valueBuilder = $valueBuilder;
        $this->programRepo = $programRepo;
        $this->locale = $request->getHeaderLine('Accept-Language');
        $this->codeGenerator = $codeGenerator;
    }

    public function build(InputBag $data)
    {
        $program = new Program();
        $program->setSlug($data['language'] . '-' . (new Slugify())->slugify($data['title']));
        $this->save($data, $program);
        return $program;
    }

    public function update(InputBag $data, $program)
    {
        $this->save($data, $program);
    }

    protected function save(InputBag $data, Program $program)
    {
        $translation = $program->translate($this->locale);

        foreach (['title', 'description'] as $key) {
            if (isset($data[$key])) {
                $translation->{'set' . ucfirst($key)}($data[$key]);
            }
        }

        foreach (['code', 'language'] as $key) {
            if (isset($data[$key])) {
                $program->{'set' . ucfirst($key)}($data[$key]);
            }
        }

        if (isset($data['inputs']) && is_array($data['inputs'])) {
            foreach ($data['inputs'] as $input) {
                $input = new InputBag($input);
                if( ($programInput = $program->getInputByName($input['name']))) {
                    $this->valueBuilder->update($input, $programInput);
                } else {
                    $program->addInput($this->valueBuilder->build($input));
                }
            }
        }

        $program->mergeNewTranslations();
        $this->parseInputs($program);
        $this->parseWrapped($program);
        $this->codeGenerator->generateFullCode($program);
    }

    protected function parseInputs(Program $program)
    {
        $inputs = $program->getInputs()->toArray();
        $inputNames = array_map(function ($input) {
            return $input->getName();
        }, $inputs);
        $inputs = array_combine($inputNames, $inputs);
        $rawCode = $program->getCode();
        preg_match_all(self::VAR_REGEX, $rawCode, $matched);
        $parsedNames = array_unique($matched[1]);
        $program->getInputs()->clear();

        foreach ($parsedNames as $parsedName) {
            $program->addInput($inputs[$parsedName] ?? (new ProgramValue())->setName($parsedName));
        }
    }

    protected function parseWrapped(Program $program)
    {
        $wrapped = $program->getWrapped()->toArray();
        $programSlugs = array_map(function (ProgramAssociation $wrapped) {
            return $wrapped->getWrappedProgram()->getSlug();
        }, $wrapped);
        $wrapped = array_combine($programSlugs, $wrapped);
        $rawCode = $this->codeGenerator->generateFullyQualifiedCode($program);
        preg_match_all(self::PROGRAM_REGEX, $rawCode, $matched);
        $program->getWrapped()->clear();

        foreach ($matched[1] as $parsedWrapped) {
            $segments = explode(':', $parsedWrapped);
            $parsedSlug = array_shift($segments);
            if(isset($wrapped[$parsedSlug])) {
                $wrappedAssociation = $wrapped[$parsedSlug];
            } else {
                $associatedProgram = $this->programRepo->getProgramBySlug($parsedSlug);
                if(! $associatedProgram) {
                    throw new HttpErrorException(sprintf('Invalid associated program : program with slug "%s" does not exist', $parsedSlug), 400);
                }
                $wrappedAssociation = $wrapped[$parsedSlug]
                    ?? (new ProgramAssociation())->setWrappedProgram($associatedProgram);
            }

            $wrappedAssociation->getInjections()->clear();

            $inputs = $wrappedAssociation->getWrappedProgram()->getInputs()->toArray();
            $inputNames = array_map(function ($input) {
                return $input->getName();
            }, $inputs);
            $inputs = array_combine($inputNames, $inputs);

            foreach ($segments as $segment) {
                if (preg_match('/([a-zA-Z0-9\-]+?)\\((.+?)\\)/', $segment, $matches)) {
                    $inputName = $matches[1];
                    if (isset($inputs[$inputName])) {
                        $valueInjection = (new ValueInjection())
                            ->setValue($matches[2])
                            ->setProgramValue($inputs[$inputName]);
                        $wrappedAssociation->addInjection($valueInjection);
                    }
                }
            }

            $program->addWrapped($wrappedAssociation);
        }
    }

    protected function generateAssociatedInputs(Program $program)
    {
        $program->getAssociatedInputs()->clear();
        foreach ($program->getWrapped() as $wrappedAssociation) {
            $wrappedProgram = $wrappedAssociation->getWrappedProgram();
            $wrappedProgramInputs = $wrappedProgram->getAllInputs()->toArray();
            $wrappedProgramInputNames = array_map(function (ProgramValue $input) {
                return $input->getId();
            }, $wrappedProgramInputs);
            $wrappedProgramInputs = array_combine($wrappedProgramInputNames, $wrappedProgramInputs);
            foreach ($wrappedAssociation->getInjections() as $injection) {
                unset($wrappedProgramInputs[$injection->getProgramValue()->getId()]);
            }
            foreach ($wrappedProgramInputs as $input) {
                $program->getAssociatedInputs()->add($input);
            }
        }
    }
}