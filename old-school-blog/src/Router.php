<?php

declare(strict_types=1);

namespace Experiments\Blog;

use Experiments\Blog\Controller\BaseController;

final readonly class Router
{
    public function __construct(private array $routes)
    {
    }

    /**
     * @param string $path
     * @return array{route: array{path: string, controller: BaseController}, matches: array<int|string, string>}
     */
    public function getRouteMatch(string $path): array
    {
        foreach ($this->routes as $routeName => $route) {
            if (preg_match($route['path'], $path, $matches)) {
                return [
                    'route' => $route,
                    'matches' => $matches,
                ];
            }
        }
        throw new \RuntimeException('404 Not Found');
    }
}