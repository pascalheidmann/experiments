<?php

declare(strict_types=1);

use Experiments\ReactivePhp\Promise\LazyPromise;

require __DIR__ . '/../vendor/autoload.php';

$lazyPromise = new LazyPromise(function (callable $resolve, callable $reject) {
    $resolve('Success!');
});

$lazyPromise->then(static function (string $result) {
    echo $result . PHP_EOL;
});

$lazyVar = false;
$lazyPromise2 = new LazyPromise(function (callable $resolve, callable $reject) use (&$lazyVar) {
    $lazyVar ? $resolve('Success!') : $reject('Failed!');
});

$lazyPromise2->then(static function (string $result) {
    echo $result . PHP_EOL;
}, static function (string $result) {
    echo $result . PHP_EOL;
});

$lazyVar = true;
$lazyPromise2->then(static function (string $result) {
    echo $result . PHP_EOL;
}, static function (string $result) {
    echo $result . PHP_EOL;
});