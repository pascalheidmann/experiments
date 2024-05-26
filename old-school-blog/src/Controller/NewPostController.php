<?php

declare(strict_types=1);

namespace Experiments\Blog\Controller;

use Experiments\Blog\Repository\PostRepository;

final class NewPostController extends BaseController
{
    public function __invoke(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost();
        }
        return $this->getForm();
    }

    private function getForm(): string
    {
        return <<<HTML
        <form method="post">
            <p>
            <label for="title">Title</label>
            <input type="text" name="title" id="title">
            </p><p>
            <label for="content">Content</label>
            <textarea name="content" id="content"></textarea>
            </p>
            <button type="submit">Submit</button>
        </form>
        HTML;
    }

    private function handlePost(): never
    {
        $title = $_POST['title'];
        $content = nl2br($_POST['content']);

        $repo = new PostRepository();
        $postId = $repo->addPost($title, $content);

        header('Location: /post/' . $postId);
        exit;
    }
}