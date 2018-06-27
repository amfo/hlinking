<?php

namespace system;

class Control
{
	public static function show404() {
		header('Content-Type: text/html; charset=UTF-8');
		header("Status: 404 Not Found", true, 404);
		include ROOT . '/views/404.phtml';
		exit;
	}

	public static function forbidden() {
		header('Content-Type: text/html; charset=UTF-8');
		header("Status: 403 Forbidden", true, 403);
		include ROOT . '/views/403.phtml';
		exit;
	}

	public static function error500($message = "") {
		header('Content-Type: text/html; charset=UTF-8');
		header("HTTP/1.1 500 Internal Server Error", true, 500);
		include ROOT . '/views/500.phtml';
		exit;
	}

	public static function redirect($url) {
		$path = parse_url($url);
		if (!isset($path['host'])) {
			$url = HOST . $url;
		}

		header('Location: ' . $url);
		exit;
	}
}