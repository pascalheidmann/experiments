<?php

declare(strict_types=1);

namespace Experiments\Blog;

final class ServiceContainer
{
    private array $alias = [];
    private array $services = [];
    private array $factories = [];

    public function get(string $service): mixed {
        if (isset($this->alias[$service])) {
            $service = $this->alias[$service];
            return $this->get($service);
        }

        if (!isset($this->services[$service]) && isset($this->factories[$service])) {
            $createdService = $this->factories[$service]($service, $this);
            if ($createdService){
                $this->services[$service] = $createdService;
            }
        }

        return $this->services[$service] ?? null;
    }

    public function addService(string $service, mixed $instance): void {
        $this->services[$service] = $instance;
    }

    public function addFactory(string $factory, callable $factoryFunction): void {
        $this->factories[$factory] = $factoryFunction;
    }
}