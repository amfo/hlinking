<?php

namespace System;

class Sessions
{

	const ERROR_CLONE = 'No se puede clonar la instancia';
	const ERROR_SERIALIZE = 'No se puede serializar la instancia';
	private static $instance;

	private function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
	}

	public static function getInstance() {
		if (!self::$instance instanceof self) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function isActiveSession() {
		return (isset($_SESSION['user_profile']) && !empty($_SESSION['user_profile']));
	}

	public function getUserSession($key) {
		if (isset($_SESSION['user_profile']) && isset($_SESSION['user_profile'][$key])) {
			return $_SESSION['user_profile'][$key];
		}

		return "";
	}

	public function setUserSession($key, $value) {
		$_SESSION['user_profile'][$key] = $value;
	}

	public function unsetUserSession($key) {
		if (isset($_SESSION['user_profile']) && isset($_SESSION['user_profile'][$key])) {
			unset($_SESSION['user_profile'][$key]);
		}
	}

	public function getGlobalSession($key) {
		if (isset($_SESSION['misc']) && isset($_SESSION['misc'][$key])) {
			return $_SESSION['misc'][$key];
		}

		return "";
	}

	public function setGlobalSession($key, $value) {
		$_SESSION['misc'][$key] = $value;
	}

	public function unsetGlobalSession($key) {
		if (isset($_SESSION['misc']) && isset($_SESSION['misc'][$key])) {
			unset($_SESSION['misc'][$key]);
		}
	}

	public function destroySession() {
		$_SESSION = null;
		unset($_SESSION);
		session_destroy();
	}

	public function __clone() {
		throw new \ErrorException(self::ERROR_CLONE);
	}

	public function __wakeup() {
		throw new \ErrorException(self::ERROR_SERIALIZE);
	}
}