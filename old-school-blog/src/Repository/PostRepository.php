<?php

declare(strict_types=1);

namespace Experiments\Blog\Repository;

final readonly class PostRepository
{
    public function getPosts(int $page = 1, int $perPage = 10, string $order = 'ASC'): array
    {
        global $DATABASE;

        $query = sprintf(
            'SELECT * FROM posts ORDER BY id %s LIMIT %d, %d',
            $order,
            ($page - 1) * $perPage,
            $perPage,
        );
        return $DATABASE->query($query);
    }

    public function getSinglePost(int $postId): ?array
    {
        global $DATABASE;

        $query = sprintf(
            'SELECT * FROM posts WHERE id = %d',
            $postId,
        );
        return $DATABASE->query($query)[0] ?? null;
    }

    public function addPost(string $title, string $content): int
    {
        global $DATABASE;
        return $DATABASE->insert('posts', ['title' => $title, 'content' => $content]);
    }
}