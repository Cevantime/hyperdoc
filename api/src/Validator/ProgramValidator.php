<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 30/09/18
 * Time: 16:30
 */

namespace App\Validator;


use Sherpa\Rest\Validator\RestValidatorInterface;

class ProgramValidator implements RestValidatorInterface
{
    /**
     * @return boolean
     */
    public function validate(array &$data, array &$errors)
    {
        if(isset($data['slug'])) {
            $errors[] = 'You cannot set slug for a program since it deduced from english title on program creation';
            return false;
        }
        return true;
    }
}