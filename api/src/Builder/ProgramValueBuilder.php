<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 18:21
 */

namespace App\Builder;


use App\Entity\ProgramValue;
use Sherpa\Rest\Builder\RestBuilderInterface;

class ProgramValueBuilder implements RestBuilderInterface
{

    public function build(array $data, $locale = '')
    {
        $progamValue = new ProgramValue();

        $this->update($data, $progamValue);

        return $progamValue;
    }

    public function update(array $data, $programValue, $locale = '')
    {
        foreach (['name', 'type', 'value', 'defaultValue'] as $value) {
            if(isset($data[$value])) {
                $programValue->{'set' . ucfirst($value)}($data[$value]);
            }
        }
    }
}