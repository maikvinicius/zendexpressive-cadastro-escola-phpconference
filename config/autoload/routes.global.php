<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
            App\Action\PingAction::class => App\Action\PingAction::class,
        ],
        'factories' => [
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class,
            App\Action\AlunoAction::class => App\Action\AlunoFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => App\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'api.ping',
            'path' => '/api/ping',
            'middleware' => App\Action\PingAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'list',
            'path' => '/alunos',
            'middleware' => App\Action\AlunoAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'edit',
            'path' => '/aluno/edit[/{matricula: \d+}]',
            'middleware' => App\Action\AlunoAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'save',
            'path' => '/aluno/save',
            'middleware' => App\Action\AlunoAction::class,
            'allowed_methods' => ['POST'],
        ],
        [
            'name' => 'delete',
            'path' => '/aluno/delete[/{matricula: \d+}]',
            'middleware' => App\Action\AlunoAction::class,
            'allowed_methods' => ['GET'],
        ],                
    ],
];
