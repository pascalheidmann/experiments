<?php

declare(strict_types=1);

namespace Experiments\Blog\Service;

final readonly class ProductionBlogHeaderImageService implements BlogHeaderImageService
{
    public function getHeaderImage(): string
    {
        return 'https://source.unsplash.com/random/1600x800?city,night';
    }
}