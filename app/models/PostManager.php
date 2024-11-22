<?php

namespace App\Models;

use PDO;

class PostManager extends Manager
{
    protected string $table = 'post';

    public function findAll(): array
    {
        $query = $this->requete("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $query->fetchAll(PDO::FETCH_CLASS, Post::class) ?: [];
    }

    public function find($value, string $column = 'id'): ?Post
    {
        $allowedFields = ['id', 'user_id', 'title'];
        if (!in_array($column, $allowedFields, true)) {
            throw new \InvalidArgumentException("Le champ '$column' n'est pas autorisé.");
        }

        $query = $this->requete("SELECT * FROM {$this->table} WHERE {$column} = :value", ['value' => $value]);
        return $query->fetchObject(Post::class) ?: null;
    }

    public function create(Post $post): bool
    {
        $query = $this->requete("
            INSERT INTO {$this->table} (user_id, title, chapo, content, created_at)
            VALUES (:user_id, :title, :chapo, :content, NOW())
        ", [
            'user_id' => $post->getUserId(),
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
        ]);

        return $query->rowCount() > 0;
    }

    public function update(Post $post): bool
    {
        $query = $this->requete("
            UPDATE {$this->table}
            SET 
                title = :title,
                chapo = :chapo,
                content = :content,
                update_at = NOW()
            WHERE id = :id
        ", [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
        ]);

        return $query->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $query = $this->requete("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
        return $query->rowCount() > 0;
    }
}
