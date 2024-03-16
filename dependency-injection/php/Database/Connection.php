<?php

namespace App\Database;

class Connection implements ConnectionInterface
{
    public function __construct(
        private string $host,
        private string $port,
        private string $user,
        private string $password,
    )
    {
    }

    public function query(string $sql): array
    {
        return [];
    }
}