<?php

namespace App;

class Kernel
{
    public function __construct(
        private ServiceContainer $serviceContainer = new ServiceContainer(),
    )
    {
    }

    public function run(string $name, array $arguments = []): void
    {
        $this->serviceContainer->get($name)(...$arguments);
    }
}