<?php
require "vendor/autoload.php";

use Framework\Route\Request;
use Framework\Route\Router;
use Framework\Route\Routing;

(new Routing)->matchRoute();

echo '<pre>';
print_r([
    
]) . PHP_EOL;