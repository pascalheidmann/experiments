<?php
declare(strict_types=1);

namespace Experiments\Blog\Service;

interface BlogHeaderImageService
{
    public function getHeaderImage(): string;
}