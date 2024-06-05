<?php

declare(strict_types=1);

namespace Experiments\Blog\Repository;

use Experiments\Blog\Database;

final readonly class PostRepository
{
    public function __construct(private Database $database)
    {
    }

    public function getPosts(int $page = 1, int $perPage = 10, string $order = 'ASC'): array
    {
        $query = sprintf(
            'SELECT * FROM posts ORDER BY id %s LIMIT %d, %d',
            $order,
            ($page - 1) * $perPage,
            $perPage,
        );
        return $this->database->query($query);
    }

    public function getSinglePost(int $postId): ?array
    {
        $query = sprintf(
            'SELECT * FROM posts WHERE id = %d',
            $postId,
        );
        return $this->database->query($query)[0] ?? null;
    }

    public function addPost(string $title, string $content): int
    {
        return $this->database->insert('posts', ['title' => $title, 'content' => $content]);
    }
}