<?php

namespace Io;

class Views
{

	public static function loadView($view, $params = []) {
		$file = VIEW_PATH . '/' . strtolower($view) . '.phtml';
		$params = array_merge(self::getDefaultParams(), $params);

		if (file_exists($file)) {
			include $file;
		} else {
			echo $view;
		}
	}

	private static function getDefaultParams() {
		return [
			'title' => ""
		];
	}
}