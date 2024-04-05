<?php

namespace Experiments\ReactivePhp\Promise;

/**
 * @template T
 * @template Q
 */
class LazyPromise
{
    public const REJECTED = 'REJECTED';
    public const PENDING = 'PENDING';
    public const RESOLVED = 'RESOLVED';

    private string $state = self::PENDING;
    private mixed $value;
    /** @var callable(callable(T), callable(Q)): (mixed|LazyPromise) $handler */
    private mixed $callback;

    /**
     * @param callable(callable(T), callable(Q)): (mixed|LazyPromise) $handler
     */
    public function __construct(callable $handler)
    {
        $this->callback = $handler;
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
        $rejected ??= static function (mixed $value): void {};

        if ($this->state === self::PENDING) {
            ($this->callback)($this->fulfill(...), $this->reject(...));
        }

        if ($this->state === self::RESOLVED) {
            $fulfilled($this->value);
        } elseif ($this->state === self::REJECTED) {
            $rejected($this->value);
        }
    }
}