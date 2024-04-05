<?php

namespace Experiments\ReactivePhp\Operators;

/**
 * @template T
 * @template O
 */
interface NextOperatorInterface extends OperatorInterface
{
    /**
     * @param T $value
     * @return O
     */
    public function next(mixed $value): mixed;
}