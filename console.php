#!/usr/bin/env php
<?php declare(strict_types=1);

define('APP_CONSOLE', true);

require __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.php';

$Kernel = new \App\Console\Kernel();

exit($Kernel->handle());
