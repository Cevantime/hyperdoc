<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 04/11/18
 * Time: 18:16
 */

namespace App\Traits;


use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Zend\Diactoros\Response\JsonResponse;

trait JsonTrait
{
    public function jsonOne($data, TransformerAbstract $transformer)
    {
        return new JsonResponse((new Manager())->createData((new Item($data, $transformer)))->toArray());
    }
}