<?php

use App\AutowiringFactory;
use App\Database\Connection;
use App\Database\ConnectionInterface;
use App\Database\DocumentRepository;
use App\Kernel;
use App\MyApp;
use App\Resolver\AutoDiscoveryResolver;
use App\Resolver\ConfigurableResolver;
use App\ServiceContainer;

include_once __DIR__ . '/vendor/autoload.php';

$config = [
    'alias' => [
        ConnectionInterface::class => Connection::class,
    ],
    'factories' => [
        Connection::class => fn() => new Connection('127.0.0.1', 3306, 'user', 'password'),
        DocumentRepository::class => fn(ServiceContainer $container) => new DocumentRepository(
            $container->get(ConnectionInterface::class)
        ),
        //MyApp::class => fn(ServiceContainer $container) => new MyApp($container->get(DocumentRepository::class)),
        //MyApp::class => AutowiringFactory::class
    ],
];

$kernel = new Kernel(
    new ServiceContainer(
        [
            new ConfigurableResolver($config),
            new AutoDiscoveryResolver(),
        ],
    )
);
$kernel->run(MyApp::class);
