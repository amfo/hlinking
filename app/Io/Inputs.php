<?php

namespace Io;

class Inputs
{
	public function get($key) {
		return (isset($_GET[$key])) ? filter_var(trim($_GET[$key]), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) : "";
	}

	public function post($key) {
		if (isset($_POST[$key]) && is_array($_POST[$key])) {
			return $_POST[$key];
		}

		return (isset($_POST[$key])) ? trim($_POST[$key]) : "";
	}

	public function referrer() {
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
	}
}