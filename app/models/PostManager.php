<?php

namespace App\Models;

class PostManager extends Manager
{
    protected $table = 'post';

    // Récupère tous les articles
    public function findAll()
    {
        return $this->requete('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC')->fetchAll();
    }

    // Récupère un article par son ID
    public function find($id, $column = 'id')
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE {$column} = ?", [$id])->fetch();
    }
}
