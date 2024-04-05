<?php

namespace Experiments\ReactivePhp;

use Experiments\ReactivePhp\Operators\OperatorInterface;

class Observable
{
    private bool $completed = false;
    /**
     * @var array<int, Observable>
     */
    private array $subscribers = [];
    private ?int $subscription = null;

    public function __construct(private readonly ?Observable $source)
    {
    }

    public function pipe(OperatorInterface ...$operators): self
    {

    }

    public function subscribe(callable $callback): int
    {
        if ($this->completed) {
            throw new \LogicException('Cannot subscribe to completed observable');
        }

        $this->subscribers[] = $callback;

        if (!$this->subscription) {
            $this->subscription = $this->source?->subscribe($this->next(...));
        }

        return array_key_last($this->subscribers);
    }

    public function unsubscribe(int $subscription): void {
        unset($this->subscribers[$subscription]);

        if (count($this->subscribers) === 0) {
            $this->source?->unsubscribe($this->subscription);
        }
    }

    public function complete(): void {
        $this->completed = true;
        foreach ($this->subscribers as $subscriber) {
            $subscriber->complete();
        }
    }

    public function next(mixed $value): void {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->next($value);
        }
    }
}