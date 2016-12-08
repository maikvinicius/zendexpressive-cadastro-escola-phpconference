<?php
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            Application::class => ApplicationFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            'DbAdapter' => Zend\Db\Adapter\AdapterServiceFactory::class,
            'Zend\Expressive\Template\TemplateRendererInterface' => Zend\Expressive\Plates\PlatesRendererFactory::class
        ],
    ],
    'db' => [
        'driver' => 'Pdo',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ],
        'dsn' => 'mysql:host=localhost;dbname=escola',
        'username' => 'root',
        'password' => 'phpconf'
    ],
    'templates' => [
        'extension' => 'phtml',
        'layout'    => 'layout/dafault',
        'map'       => [
            'layout/default'    => 'templates/layout/default.phtml',
            'error/error'       => 'templates/error/error.phtml',
            'error/404'         => 'template/error/404.phtml'
        ],
        'paths' => [
            'app'   => ['templates/app'],
            'layout'    => ['templates/layout'],
            'error' => ['templates/error']
        ]
    ]
];
