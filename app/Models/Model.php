<?php

namespace Models;

use System\Sessions;

class Model extends \PDO
{
	const DUPLICATE_KEY_CODE = 1062;

	public function __construct() {
		$dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
		parent::__construct($dsn, DB_USER, DB_PASS);
	}
}