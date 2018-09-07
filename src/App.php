<?php

namespace App;

use Sherpa\App\App as BaseApp;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Description of App
 *
 * @author cevantime
 */
class App extends BaseApp
{

    public function json($data, $status = 200, $headers = array(), $encodingOptions = JsonResponse::DEFAULT_JSON_FLAGS)
    {
        return new JsonResponse($data, $status, $headers, $encodingOptions);
    }

}
