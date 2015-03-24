#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use TukevastiIlmassaDataCombiner\Console\Command\RunCommand;

$application = new Application("Tukevasti Ilmassa Data Combiner");
$application->add(new RunCommand);
$application->run();
