<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 04/11/18
 * Time: 18:04
 */

namespace App\Controller;


use App\Traits\JsonTrait;
use App\Transformer\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Controller\AppController;
use Zend\Diactoros\Response\JsonResponse;

class ProfileController extends AppController
{
    use JsonTrait;

    public function getProfile(ServerRequestInterface $request, UserTransformer $userTransformer)
    {
        return $this->jsonOne($request->getAttribute('user'), $userTransformer);
    }
}