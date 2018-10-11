<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 17:16
 */

namespace App\Transformer;


use App\Entity\Program;
use App\Entity\ProgramValue;
use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use League\Fractal\ParamBag;
use Sherpa\Rest\Utils\Bag;
use League\Fractal\TransformerAbstract;

class ProgramTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'description',
        'exec',
        'inputs',
        'outputs',
        'code',
        'full-code',
        'extended-inputs'
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
            'language' => $program->getLanguage()
        ];
    }

    public function includeInputs(Program $program)
    {
        return $this->collection($program->getInputs(), $this->programValueTransformer);
    }

    public function includeExtendedInputs(Program $program)
    {
        return $this->collection($program->getAllInputs(), $this->programValueTransformer);
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

        $inputs = $program->getAllInputs();
        $code = $program->getFullCode();

        foreach($inputs as $input) {
            $valueProvided =  $params->get($input->getName());
            if($input->getDefaultValue() === null && $valueProvided === null) {
                throw new \Exception(sprintf("%s input is required to get executable code", $input->getName()));
            } else {
                $code = str_replace(sprintf('[[%s@%s]]', $input->getProgramInput()->getSlug(), $input->getName()), $valueProvided[0] ?? $input->getDefaultValue(), $code);
            }
        }

        return $this->primitive($code);
    }

    public function includeFullCode(Program $program)
    {
        return $this->primitive($program->getFullCode());
    }

    public function includeDescription(Program $program)
    {
        return $this->primitive($program->getDescription());
    }

    public function includeCode(Program $program)
    {
        return $this->primitive($program->getCode());
    }
}