<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 30/09/18
 * Time: 16:30
 */

namespace App\Validator;


use App\Repository\ProgramRepository;
use Cocur\Slugify\Slugify;
use Sherpa\Rest\Validator\InputBag;
use Sherpa\Rest\Validator\RestValidatorInterface;

class ProgramValidator implements RestValidatorInterface
{
    /**
     * @var ProgramRepository
     */
    private $programRepository;

    const LANGUAGES = ['bash'];

    /**
     * ProgramValidator constructor.
     * @param ProgramRepository $programRepository
     */
    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
    }

    /**
     * @return boolean
     */
    public function validate(InputBag $input)
    {
        if (isset($input['slug'])) {
            $input->getErrors()[] = 'You cannot set slug for a program since it deduced from english title on program creation';
            return false;
        }

        if (!isset($input['language']) || !in_array($input['language'], self::LANGUAGES)) {
            $input->getErrors()[] = 'The provided language does not exist or is invalid';
        }

        $slug = $input['language'] . '-' . (new Slugify())->slugify($input['title']);
        $program = $this->programRepository->getProgramBySlug($slug);

        if ($program !== null) {
            $input->getErrors()[] = "A program with the same name already exists in this language";
            return false;
        }

        return true;
    }
}