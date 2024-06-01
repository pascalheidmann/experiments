<?php

namespace App;

use App\Resolver\ResolverInterface;

class ServiceContainer
{
    /**
     * @param array<int, ResolverInterface> $resolvers
     * @param array<string, mixed> $services
     */
    public function __construct(
        private array $resolvers = [],
        private array $services = [],
    )
    {
    }

    public function has(string $name): bool
    {
        return isset($this->services[$name]) || $this->canResolve($name);
    }

    public function get(string $name): mixed
    {
        return $this->services[$name] ?? $this->resolve($name);
    }

    private function canResolve(string $name): bool
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->canResolve($name)) {
                return true;
            }
        }
        return false;
    }

    private function resolve(string $name): mixed
    {
        foreach ($this->resolvers as $resolver) {
            $resolved = $resolver->resolve($name, $this);

            if ($resolved) {
                // cache it
                $this->services[$name] = $resolved;
                return $resolved;
            }
        }
        throw new \RuntimeException("Service '$name' not found");
    }
}