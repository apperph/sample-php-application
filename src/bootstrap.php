<?php

namespace ApperPH\SamplePHPApplication;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

require_once 'router.php';
