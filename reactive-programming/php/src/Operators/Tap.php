<?php

namespace Experiments\ReactivePhp\Operators;

/**
 * @template T
 * @extends NextOperatorInterface<T, T>
 */
class Tap implements NextOperatorInterface
{
    /**
     * @param callable(T): T $callback
     */
    public function __construct(
        private mixed $callback
    )
    {
    }

    public function next(mixed $value): mixed
    {
        $this->callback($value);
        return $value;
    }
}