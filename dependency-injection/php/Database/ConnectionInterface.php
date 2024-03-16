<?php

namespace App\Database;

interface ConnectionInterface
{
    public function query(string $sql): array;
}