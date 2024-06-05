<?php

declare(strict_types=1);

namespace Experiments\Blog;

final readonly class AutowiringFactory
{
    public function __invoke(string $service, ServiceContainer $container)
    {
        $serviceClass = new \ReflectionClass($service);
        $constructor = $serviceClass->getConstructor();
        if ($constructor === null) {
            return new $service();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();
            if ($dependency === null) {
                throw new \Exception('Cannot autowire service: ' . $service);
            }

            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }


            $dependencies[] = $container->get($dependency->getName()) ?? $container->get($parameter->getName());
        }

        return $serviceClass->newInstanceArgs($dependencies);
    }
}