<?php

function setReporting() {
	if (DEVELOPMENT_ENVIRONMENT == true) {
		error_reporting(E_ALL);
		ini_set('display_errors','On');
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
	}
}


function performAction($controller,$action,$queryString = null,$render = 0) {
	
	$controllerName = ucfirst($controller).'Controller';
	$dispatch = new $controllerName($controller,$action);
	$dispatch->render = $render;
	return call_user_func_array(array($dispatch,$action),$queryString);
}


function callHook() {
	global $url;
	global $default;

	$queryString = array();

	
	if (empty($url)) {
		// print_r("App_URL: ". $url."<br>");
		$controller = $default['controller'];
		$action = $default['action'];
		// print_r("controller: ". $controller ."<br>");
		// print_r("action: ". $action."<br>");
	} else {
		$urlArray = array();
		$urlArray = explode("/",$url);
		$controller = $urlArray[0];
		// print_r("controller: ". $controller ."<br>");
		array_shift($urlArray);
		if (!empty($urlArray[0])) {
			$action = $urlArray[0];
			array_shift($urlArray);
			// print_r("action: ". $action."<br>");
		} else {
			$action = 'index'; // Default Action
			// print_r("action: ". $action."<br>");
			
		}
		$queryString = $urlArray;

		// print_r("atribute: ". $queryString[0]."<br>");

	}
	
	$controllerName = ucfirst($controller).'Controller';

	$dispatch = new $controllerName($controller,$action);
	
	if ((int)method_exists($controllerName, $action)) {
		call_user_func_array(array($dispatch,"beforeAction"),$queryString);
		call_user_func_array(array($dispatch,$action),$queryString);
		call_user_func_array(array($dispatch,"afterAction"),$queryString);
	} else {
		/* Error Generation Code Here */
	}
}


spl_autoload_register( function($className) {
	if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
		require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
	} else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php');
	} else if (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php');
	} else {
		// print_r("Error check <br>");
		require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'error' . '.php');
	}
});


setReporting();
callHook();

