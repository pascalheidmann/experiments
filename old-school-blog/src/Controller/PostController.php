<?php

declare(strict_types=1);

namespace Experiments\Blog\Controller;

use Experiments\Blog\Repository\PostRepository;

final class PostController extends BaseController
{
    private PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function __invoke(array $matches): string
    {
        $postId = (int) $matches['id'];
        $post = $this->postRepository->getSinglePost($postId);
        if ($post === null) {
            return '404 Not Found';
        }

        return $this->getPostHtml($post);
    }

    private function getPostHtml(array $post): string
    {
        return <<<HTML
        <article>
            <h2>{$post['title']}</h2>
            <p>{$post['content']}</p>
        </article>
        HTML;
    }
}