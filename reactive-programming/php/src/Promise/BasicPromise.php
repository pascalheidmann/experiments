<?php

namespace Experiments\ReactivePhp\Promise;

/**
 * @template T
 * @template Q
 */
class BasicPromise
{
    public const REJECTED = 'REJECTED';
    public const PENDING = 'PENDING';
    public const RESOLVED = 'RESOLVED';

    private string $state = self::PENDING;
    private mixed $value;

    /**
     * @param callable(callable(T), callable(Q)): (mixed|LazyPromise) $handler
     */
    public function __construct(callable $handler)
    {
        try {
            $handler($this->fulfill(...), $this->reject(...));
        } catch (\Throwable $exception) {
            $this->reject($exception);
        }
    }
    
    private function fulfill(mixed $result): void {
        $this->value = $result;
        $this->state = self::RESOLVED;
    }

    private function reject(mixed $error): void {
        $this->value = $error;
        $this->state = self::REJECTED;
    }

    public function then(callable $fulfilled, ?callable $rejected = null): void
    {
        if ($this->state === self::RESOLVED) {
            $fulfilled($this->value);
        } else if ($this->state === self::REJECTED && $rejected) {
            $rejected($this->value);
        }
    }
}