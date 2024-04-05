<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$promiseV1 = new \Experiments\ReactivePhp\Promise\BasicPromise(
    static function (callable $fulfill, callable $reject): void {
        $randomNumber = random_int(0, 100);
        if ($randomNumber % 2 === 0) {
            $fulfill($randomNumber);
        } else {
            $reject($randomNumber);
        }
    }
);


$promiseV1->then(
    static function (mixed $result): void {
        echo 'Resolved: Is even: ' . $result .PHP_EOL;
    },
    static function (mixed $result): void {
        echo 'Rejected: is odd: ' . $result .PHP_EOL;
    }
);

$promiseV1->then(
    static function (mixed $result): void {
        echo 'Resolved: Is still even: ' . $result .PHP_EOL;
    },
    static function (mixed $result): void {
        echo 'Rejected: is still odd: ' . $result .PHP_EOL;
    }
);

