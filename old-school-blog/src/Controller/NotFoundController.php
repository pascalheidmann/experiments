<?php

declare(strict_types=1);

namespace Experiments\Blog\Controller;

final class NotFoundController extends BaseController
{
    public function __invoke(): string
    {
        return '404 Not Found';
    }
}