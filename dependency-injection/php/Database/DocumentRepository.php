<?php

namespace App\Database;

class DocumentRepository
{
    public function __construct(private ConnectionInterface $db)
    {
    }

    public function find($id): array
    {
        return $this->db->query('SELECT * FROM document WHERE id=' . $id);
    }
}