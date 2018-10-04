<?php

namespace App\Base;

use Sherpa\Rest\Controller\RestController;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Description of Controller
 * @author cevantime
 */
class Controller extends RestController
{
    /**
     *
     * @var \DI\Container
     */
    protected $container;
    
    public function __construct(\DI\Container $container, string $entityClass)
    {
        parent::__construct($entityClass);
        $this->container = $container;
    }
}
