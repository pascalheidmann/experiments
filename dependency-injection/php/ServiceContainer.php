<?php

namespace App;

class ServiceContainer
{
    private array $services = [];
    private array $alias = [];
    private array $factories = [];

    public function has(string $name): bool
    {
        return isset($this->services[$name]) || isset($this->alias[$name]) || isset($this->factories[$name]);
    }

    public function set(string $name, mixed $service): void
    {
        $this->services[$name] = $service;
    }

    public function alias(string $name, string $alias): void
    {
        $this->alias[$name] = $alias;
    }

    public function setFactory(string $name, callable|string $factory): void
    {
        $this->factories[$name] = $factory;
    }

    public function get(string $name): mixed
    {
        if (isset($this->alias[$name])) {
            return $this->get($this->alias[$name]);
        }

        if (!isset($this->services[$name])) {
            $this->set($name, $this->create($name));
        }
        return $this->services[$name];
    }

    public function create(string $name): mixed
    {
        $factory = $this->factories[$name] ?? null;

        if (is_string($factory) && class_exists($factory)) {
            $factory = new $factory();
        }

        if (is_callable($factory)) {
            // shortcut to not recreate factory all the time
            $this->factories[$name] = $factory;
            return $factory($this, $name);
        }

        if ($factory !== null) {
            throw new \RuntimeException('Factory is not callable for service ' . $name);
        }
        throw new \RuntimeException('Unknown service ' . $name);
    }
}