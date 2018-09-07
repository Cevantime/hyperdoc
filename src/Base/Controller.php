<?php

namespace App\Base;

use App\App;

/**
 * Description of Controller
 *
 * @author cevantime
 */
class Controller
{
    /**
     *
     * @var App
     */
    protected $app;
    
    public function __construct(App $app)
    {
        $this->app = $app;
    }
    
}
