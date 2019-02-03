<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 03/02/19
 * Time: 11:05
 */

namespace App\Controller;


use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Rest\Controller\RestCrudController;

class ProgramController extends RestCrudController
{
    public function search(ServerRequestInterface $request)
    {
        return $this->createListResponse($request);
    }
}