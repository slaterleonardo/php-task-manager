<?php

define('BASE_PATH', __DIR__ . '/../');
define('APP_PATH', BASE_PATH . 'app/');
define('SERVICES_PATH', APP_PATH . 'Services/');
define('PUBLIC_PATH', BASE_PATH . 'public/');
define('CONFIG_PATH', BASE_PATH . 'Config/');
define('VIEW_PATH', BASE_PATH . 'Views/');
define('PARTIAL_PATH', VIEW_PATH . 'partials/');

require_once CONFIG_PATH . 'database.php';