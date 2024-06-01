<?php

namespace App\Resolver;

use App\ServiceContainer;

class ConfigurableResolver implements ResolverInterface
{
    private array $factories = [];

    public function __construct(private array $config = [])
    {
    }

    public function canResolve(string $class): bool
    {
        return isset($this->config['alias'][$class]) || isset($this->config['factories'][$class]);
    }

    public function resolve(string $class, ServiceContainer $container): mixed {
        if (isset($this->config['alias'][$class])) {
            return $this->resolve($this->config['alias'][$class], $container);
        }

        return $this->create($container, $class);
    }

    private function create(ServiceContainer $container, string $class): mixed
    {
        $factory = $this->config['factories'][$class] ?? null;

        if (is_string($factory)) {
            // reuse factory instances (eg autowiring factory)
            if (isset($this->factories[$factory])) {
                $factory = $this->factories[$factory];
            } elseif (class_exists($factory)) {
                $factory = new $factory();
                $this->factories[$factory::class] = $factory;
            }
        }

        if (is_callable($factory)) {
            // shortcut to not recreate factory all the time
            $this->config['factories'][$class] = $factory;
            return $factory($container, $class);
        }
        return null;
    }
}