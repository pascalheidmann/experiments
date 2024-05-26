<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

$DATABASE = \Experiments\Blog\Database::getInstance();

$router = new \Experiments\Blog\Router(
    [
        'home' => [
            'path' => '/^\/$/',
            'controller' => new \Experiments\Blog\Controller\HomeController()
        ],
        'homePage' => [
            'path' => '/^\/page\/(?<page>\d+)$/',
            'controller' => new \Experiments\Blog\Controller\HomeController()
        ],
        'newPost' => [
            'path' => '/^\/post\/new/ ',
            'controller' => new \Experiments\Blog\Controller\NewPostController()
        ],
        'post' => [
            'path' => '/^\/post\/(?<id>\d+)/',
            'controller' => new \Experiments\Blog\Controller\PostController()
        ],
        'not_found' => [
            'path' => '/.*/',
            'controller' => new \Experiments\Blog\Controller\NotFoundController()
        ],
    ]
);

$routeMatch = $router->getRouteMatch($_SERVER['REQUEST_URI']);

echo '<a href="/"><h1>My very impressive tech Blog 🖥️</h1></a>';

echo $routeMatch['route']['controller']($routeMatch['matches']);

echo '<p>(c) 2023 by <a href="https://www.example.com">John Doe</a></p>';
