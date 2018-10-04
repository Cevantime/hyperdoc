<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 17:33
 */

namespace App\Transformer;


use App\Entity\ProgramValue;
use Doctrine\Common\Collections\Collection;
use League\Fractal\TransformerAbstract;

class ProgramValueTransformer extends TransformerAbstract
{
    public function transform(ProgramValue $value)
    {
        return [
            'id' => $value->getId(),
            'name' => $value->getName(),
            'type' => $value->getType(),
            'value' => $value->getValue(),
            'description' => $value->getDescription(),
            'defaultValue' => $value->getDefaultValue()
        ];
    }
}