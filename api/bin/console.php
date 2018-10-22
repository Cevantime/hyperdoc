#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/../init.php';

$app->boot();

$application = new \Symfony\Component\Console\Application();

$application->add($app->get(\App\Command\IndexPrograms::class));

$application->run();