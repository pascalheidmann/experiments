<?php

namespace App\Resolver;

use App\AutowiringFactory;
use App\ServiceContainer;

class AutoDiscoveryResolver implements ResolverInterface
{
    public function __construct(
        private readonly AutowiringFactory $autowiringFactory = new AutowiringFactory()
    )
    {
    }

    public function canResolve(string $class): bool
    {
        return class_exists($class);
    }

    public function resolve(string $class, ServiceContainer $container): mixed
    {
        return class_exists($class) ? $this->autowiringFactory->__invoke($container, $class) : null;
    }
}