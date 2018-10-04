<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 17:16
 */

namespace App\Transformer;


use App\Entity\Program;
use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;

class ProgramTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'exec',
        'inputs',
        'outputs'
    ];

    /**
     * @var ProgramValueTransformer
     */
    private $programValueTransformer;

    /**
     * @var ProgramRepository
     */
    private $programRepo;

    public function __construct(ProgramRepository $programRepo, ProgramValueTransformer $transformer)
    {
        $this->programRepo = $programRepo;
        $this->programValueTransformer = $transformer;
    }

    public function transform(Program $program)
    {
        return [
            'id' => $program->getId(),
            'slug' => $program->getSlug(),
            'title' => $program->getTitle(),
            'code' => $program->getCode(),
            'description' => $program->getDescription()
        ];
    }

    public function buildFullProgram(Program $program)
    {
        $this->buildFullProgramFinal($program, new ArrayCollection());
    }

    public function buildFullProgramFinal(Program $program, Collection $inputs)
    {
        $wrappedAssociations = $program->getWrapped();
        foreach($wrappedAssociations as $association) {
            $child = $this->buildFullProgramFinal($association->getWrappedProgram(), $inputs);
            $injections = $association->getInjections();
            $injectedValues = array_map(function($injection){
                return $injection->getProgramValue();
            }, $injections);
            foreach ($child->getInputs() as $childInput) {
                if( ! in_array($childInput, $injectedValues)) {
                    $inputs->add($childInput);
                } else {

                }
            }
        }
    }

    public function includeInputs(Program $program)
    {
        return $this->collection($program->getInputs(), $this->programValueTransformer);
    }

    public function includeOutputs(Program $program)
    {
        return $this->collection($program->getOutputs(), $this->programValueTransformer);
    }

    public function includeExec(Program $program, ParamBag $params = null)
    {
        if($params === null) {
            return null;
        }

        $inputs = $program->getInputs();
        $code = $program->getCode();

        foreach($inputs as $input) {
            $valueProvided =  $params->get($input->getName());
            if($input->getDefaultValue() === null && $valueProvided === null) {
                throw new \Exception(sprintf("%s input is required to get executable code", $input->getName()));
            } else {
                $code = str_replace(sprintf('[[%s]]', $input->getName()), $valueProvided[0] ?? $input->getDefaultValue(), $code);
            }
        }

        return $this->item($code, function($code) { return ['code' => $code] ;});
    }
}