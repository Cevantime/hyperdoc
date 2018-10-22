<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 07/11/18
 * Time: 23:46
 */

namespace App\Transformer;


use League\Fractal\TransformerAbstract;

class IndexedProgramTransformer extends TransformerAbstract
{
    public function transform($program)
    {
        return $program;
    }
}