<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 07/11/18
 * Time: 22:01
 */

namespace App\Controller;


use App\Repository\AccessTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lcobucci\JWT\Parser;
use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Controller\AppController;
use Zend\Diactoros\Response\EmptyResponse;

class TokenController extends AppController
{
    public function revokeAccessToken(ServerRequestInterface $request, AccessTokenRepository $tokenRepository)
    {
        $tokenRepository->revokeAccessToken($token = (new Parser())->parse($request->getQueryParams()['token'])->getClaim('jti'));

        return new EmptyResponse();
    }
}