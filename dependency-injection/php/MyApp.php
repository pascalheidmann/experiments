<?php

namespace App;

use App\Database\DocumentRepository;

final class MyApp
{
    public function __construct(
        private readonly DocumentRepository $documentRepository
    )
    {
    }

    public function __invoke(): void
    {
        $document = $this->documentRepository->find(1);
        echo 'hello world';
    }
}