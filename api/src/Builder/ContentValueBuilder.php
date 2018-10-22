<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 18:21
 */

namespace App\Builder;


use App\Entity\ContentValue;
use Sherpa\Rest\Utils\Bag;
use Sherpa\Rest\Builder\RestBuilderInterface;
use Sherpa\Rest\Validator\InputBag;

class ContentValueBuilder implements RestBuilderInterface
{

    public function build(InputBag $data)
    {
        $progamValue = new ContentValue();

        $this->update($data, $progamValue);

        return $progamValue;
    }

    public function update(InputBag $data, $programValue)
    {
        foreach (['name', 'type', 'value', 'description', 'defaultValue'] as $value) {
            if(isset($data[$value])) {
                $programValue->{'set' . ucfirst($value)}($data[$value]);
            }
        }
    }
}