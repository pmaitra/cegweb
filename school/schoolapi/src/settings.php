<?php
$domain = strtolower($_SERVER['HTTP_HOST']);

	switch($domain) {
	case 'qtsin.com' :
        case 'qtsin.net' :
		$_SERVER['CI_ENV'] = 'production';
	break;
        case 'phptrainingacademy.in' :
                $_SERVER['CI_ENV'] = 'testing';
            	break;
	default :
		$_SERVER['CI_ENV'] = 'development';
	break;
	}

	define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

        switch (ENVIRONMENT)
        {
            case 'development':
                    error_reporting(-1);
                    ini_set('display_errors', 1);
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'phptrain_ssp-live');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'D6yoIxlu_Fy6');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'phptrain_ssp-live');
                    ini_set('display_errors', 0);
                    if (version_compare(PHP_VERSION, '5.3', '>='))
                    {
                            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
                    }
                    else
                    {
                            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
                    }
            break;

            case 'testing':
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'phptrain_ssp-live');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'D6yoIxlu_Fy6');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'phptrain_ssp-live');
                    break;
            case 'production':
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'xd');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal');
            break;

    }
    
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        //'logger' => [
        //    'name' => 'slim-app',
        //    'path' => __DIR__ . '/../logs/app.log',
        //    'level' => \Monolog\Logger::DEBUG,
        //],
// Database connection settings
        "db" => [
            "driver" => "mysql",
            "host" => DB_HOST,
            "database" => DB_NAME,
            "username" => DB_USER,
            "password" => DB_PASSWORD
        ],
    ],
];
