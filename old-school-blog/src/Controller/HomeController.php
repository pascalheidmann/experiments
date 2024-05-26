<?php

declare(strict_types=1);

namespace Experiments\Blog\Controller;

use Experiments\Blog\Repository\PostRepository;

final class HomeController extends BaseController
{
    private const POSTS_PER_PAGE = 5;
    private PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function __invoke(array $matches): string
    {
        $page = (int)($matches['page'] ?? 1);
        $posts = $this->postRepository->getPosts($page, self::POSTS_PER_PAGE, 'DESC');

        $content = '';

        foreach ($posts as $i => $post) {
            if ($i < self::POSTS_PER_PAGE) {
                $content .= $this->getPostHtml($post);
            }
        }

        if ($page > 1) {
            $content .= '<p><a href="/page/' . ($page - 1) . '">Previous page</a></p>';
        }
        if (count($posts) > self::POSTS_PER_PAGE) {
            $content .= '<p><a href="/page/' . ($page + 1) . '">Next page</a></p>';
        }

        $content .= '<a href="/post/new">+ Write new post</a>';

        return $content;
    }

    private function getPostHtml(array $post): string
    {
        return <<<HTML
        <article>
            <a href="/post/{$post['id']}">
                <h2>{$post['title']}</h2>
            </a>
            <div>{$post['content']}</div>
        </article>
        HTML;
    }
}