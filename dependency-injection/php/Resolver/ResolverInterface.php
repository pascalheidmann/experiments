<?php

namespace App\Resolver;

use App\ServiceContainer;

interface ResolverInterface
{
    public function canResolve(string $class): bool;
    public function resolve(string $class, ServiceContainer $container): mixed;
}