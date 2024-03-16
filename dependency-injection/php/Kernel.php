<?php

namespace App;

class Kernel
{
    public function __construct(
        private ServiceContainer $serviceContainer = new ServiceContainer(),
    )
    {
    }

    /**
     * @param array{services?: array<string, mixed>, factories?: array<string, callable>, alias?: array<string, string>} $configuration
     */
    public function configure(array $configuration): void
    {
        foreach ($configuration['services'] ?? [] as $name => $service) {
            $this->serviceContainer->set($name, $service);
        }
        foreach ($configuration['alias'] ?? [] as $name => $service) {
            $this->serviceContainer->alias($name, $service);
        }
        foreach ($configuration['factories'] ?? [] as $name => $service) {
            $this->serviceContainer->setFactory($name, $service);
        }
    }

    public function run(string $name, array $arguments = []): void
    {
        $this->serviceContainer->get($name)(...$arguments);
    }
}