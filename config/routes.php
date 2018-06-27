<?php

use System\Control;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
	$r->addRoute('GET', '/', 'Controllers\Controller@dispatchUser');
	$r->addRoute('GET', '/login', 'Controllers\LoginController@viewLoginUser');
	$r->addRoute('POST', '/login', 'Controllers\LoginController@setLoginUser');
	$r->addRoute('GET', '/registro', 'Controllers\RegisterController@viewRegisterUser');
	$r->addRoute('POST', '/registro', 'Controllers\RegisterController@setRegisterUser');
	$r->addRoute('GET', '/promotion/new', 'Controllers\UserController@confirmUserPromotion');
	$r->addRoute('POST', '/promotion/new', 'Controllers\UserController@insertUserPromotion');
	$r->addRoute('GET', '/promotion/check/{id:\d+}', 'Controllers\UserController@confirmCheckUserPromotion');
	$r->addRoute('POST', '/promotion/check', 'Controllers\UserController@checkUserPromotion');
	$r->addRoute('GET', '/logout', 'Controllers\LoginController@logoutUser');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
	$uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
	case FastRoute\Dispatcher::NOT_FOUND:
		Control::show404();
		break;

	case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$allowedMethods = $routeInfo[1];
		Control::forbidden();
		break;

	case FastRoute\Dispatcher::FOUND:
		$handler = $routeInfo[1];
		$vars = $routeInfo[2];

		list($class, $method) = explode('@', $handler);
		(new $class())->$method($vars);

		break;
}