<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 18:21
 */

namespace App\Builder;


use App\Entity\ProgramValue;
use Sherpa\Rest\Utils\Bag;
use Sherpa\Rest\Builder\RestBuilderInterface;
use Sherpa\Rest\Validator\InputBag;

class ProgramValueBuilder implements RestBuilderInterface
{

    public function build(InputBag $data)
    {
        $progamValue = new ProgramValue();

        $this->update($data, $progamValue);

        return $progamValue;
    }

    public function update(InputBag $data, $programValue)
    {
        foreach (['name', 'type', 'value', 'defaultValue'] as $value) {
            if(isset($data[$value])) {
                $programValue->{'set' . ucfirst($value)}($data[$value]);
            }
        }
    }
}