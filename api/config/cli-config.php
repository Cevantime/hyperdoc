<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__.'/../init.php';

/**
 * @var \App\App $app
 */
$app->boot();

return ConsoleRunner::createHelperSet($app->get('doctrine.manager'));
