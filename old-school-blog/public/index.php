<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

const APP_ENV = 'development';

$DATABASE = \Experiments\Blog\Database::getInstance();

$serviceContainer = new \Experiments\Blog\ServiceContainer();
$serviceContainer->addService('db', $DATABASE);
$serviceContainer->addService(\Experiments\Blog\Database::class, $DATABASE);
$serviceContainer->addService(
    \Experiments\Blog\Repository\PostRepository::class,
    new \Experiments\Blog\Repository\PostRepository($DATABASE)
);
$serviceContainer->addFactory(
    \Experiments\Blog\Controller\HomeController::class,
    new \Experiments\Blog\AutowiringFactory()
);

$router = new \Experiments\Blog\Router(
    [
        'home' => [
            'path' => '/^\/$/',
            'controller' => \Experiments\Blog\Controller\HomeController::class,
        ],
        'homePage' => [
            'path' => '/^\/page\/(?<page>\d+)$/',
            'controller' => \Experiments\Blog\Controller\HomeController::class,
        ],
        'newPost' => [
            'path' => '/^\/post\/new/ ',
            'controller' => \Experiments\Blog\Controller\NewPostController::class,
        ],
        'post' => [
            'path' => '/^\/post\/(?<id>\d+)/',
            'controller' => \Experiments\Blog\Controller\PostController::class
        ],
        'not_found' => [
            'path' => '/.*/',
            'controller' => \Experiments\Blog\Controller\NotFoundController::class
        ],
    ]
);


echo '<a href="/"><h1>My very impressive tech Blog 🖥️</h1></a>';

if (APP_ENV === 'production') {
    $blogHeaderService = new \Experiments\Blog\Service\ProductionBlogHeaderImageService();
} else {
    $blogHeaderService = new \Experiments\Blog\Service\RandomImageService();
}
$blogHeaderUrl = $blogHeaderService->getHeaderImage();

//echo '<div><img src="' . $blogHeaderUrl . '" alt="Blog header image" style="width: 100%; max-height: 200px; object-fit: cover"></div>';

$routeMatch = $router->getRouteMatch($_SERVER['REQUEST_URI']);
$controller = $serviceContainer->get($routeMatch['route']['controller']);

echo $controller($routeMatch['matches']);


echo '<p><a href="/post/new">+ Write new post</a></p>';
echo '<p>(c) 2023 by <a href="https://www.example.com">John Doe</a></p>';
