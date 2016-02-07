#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Extragsm\Assets\Command\CssCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CssCommand());
$application->run();