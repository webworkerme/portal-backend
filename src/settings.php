<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // DB Settings
        'db' => [
            'host' => 'localhost',
            'name' => getenv('DBNAME'),
            'user' => getenv('DBUSER'),
            'password' => getenv('DBPASS'),
        ],

        // JWT Settings
        "jwt" => [
         'secret' => getenv('SECRET_KEY')
        ],

    ],
];
