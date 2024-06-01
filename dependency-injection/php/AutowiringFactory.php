<?php

namespace App;

class AutowiringFactory
{
    public function __invoke(ServiceContainer $container, string $name)
    {
        $reflection = new \ReflectionClass($name);
        $constructor = $reflection->getConstructor();

        $parameters = [];
        foreach ($constructor->getParameters() as $parameter) {
            $className = $parameter->getType()?->getName();
            if ($container->has($className)) {
                $parameters[$parameter->getName()] = $container->get($className);
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $parameters[$parameter->getName()] = $parameter->getDefaultValue();
                continue;
            }


            throw new \RuntimeException(
                sprintf('Could not resolve parameter %s for class %s', $parameter->getName(), $name)
            );
        }

        return new $name(...$parameters);
    }
}