<?php
declare(strict_types=1);

namespace Experiments\Blog\Service;

class RandomImageService
{
    public function getRandomImage(): string
    {
        return 'https://source.unsplash.com/random/1600x800?beach';
    }
}