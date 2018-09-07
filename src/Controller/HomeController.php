<?php

namespace App\Controller;

use App\Base\Controller;

/**
 * Description of HomeController
 *
 * @author cevantime
 */
class HomeController extends Controller
{
    public function home()
    {
        return $this->app->json([
            'message' => 'hello json'
        ]);
    }
}
