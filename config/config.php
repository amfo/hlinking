<?php
define('ROOT', dirname(__DIR__));
define('SESSION_TIME_LIMIT', 1800);
define('LOG_PATH', ROOT . '/log');
define('LOG_FILE', LOG_PATH . '/hlog_' . date('Ymd') . '.log');
define('VIEW_PATH', ROOT . '/views');
define('HOST', 'http://localhost:3000');

define('DB_USER', 'hluser');
define('DB_PASS', 'hlpassword');
define('DB_NAME', 'hlinking');
define('DB_HOST', 'localhost');

set_include_path(ROOT);