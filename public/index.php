<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));


$url = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'home';

//print_r("URL: ". $url ."<br>");


require_once (ROOT . DS . 'config' . DS. 'config.php');
require_once (ROOT . DS . 'config' . DS. 'routing.php');
require_once (ROOT . DS . 'library'. DS. 'App.php');


