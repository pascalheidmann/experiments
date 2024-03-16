<?php

namespace App;

class ServiceContainer
{
    private array $services = [];
    private array $alias = [];
    private array $factories = [];

    public function set(string $name, mixed $service): void
    {
        $this->services[$name] = $service;
    }

    public function alias(string $name, string $alias): void {
        $this->alias[$name] = $alias;
    }

    public function setFactory(string $name, callable $factory): void
    {
        $this->factories[$name] = $factory;
    }

    public function get(string $name): mixed
    {
        if (isset($this->alias[$name])) {
            return $this->get($this->alias[$name]);
        }

        if (!isset($this->services[$name])) {
            // this is new
            if (!isset($this->factories[$name])) {
                throw new \RuntimeException('Unknown service ' . $name);
            }
            $this->set($name, $this->factories[$name]($this, $name));
        }
        return $this->services[$name];
    }
}