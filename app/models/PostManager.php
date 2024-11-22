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

        error_log("Post object before insertion: " . json_encode([
            'user_id' => $post->getUserId(),
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
            'image' => $post->getImage(),
        ]));
        $query = $this->requete("
            INSERT INTO {$this->table} (user_id, title, chapo, content, image, category_id, created_at)
            VALUES (:user_id, :title, :chapo, :content, :image, :category_id, NOW())
        ", [
            'user_id' => $post->getUserId(),
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
            'image' => $post->getImage(), // Accepte une valeur NULL si aucune image n'est fournie
            'category_id' => $post->getCategoryId(),
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
                image = :image,
                category_id = :category_id,
                update_at = NOW()
            WHERE id = :id
        ", [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
            'image' => $post->getImage(), // Accepte une valeur NULL si aucune image n'est fournie
            'category_id' => $post->getCategoryId(),
        ]);

        return $query->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $query = $this->requete("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
        return $query->rowCount() > 0;
    }

    /**
     * Récupère tous les articles d'un utilisateur donné.
     *
     * @param int $userId
     * @return array
     */
    public function findByUserId(int $userId): array
    {
        $query = $this->requete("SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC", [
            'user_id' => (int) $userId,
        ]);

        return $query->fetchAll(PDO::FETCH_CLASS, Post::class) ?: [];
    }

    public function findPaginated(int $limit, int $offset): array
    {
        $query = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY created_at DESC 
            LIMIT :limit OFFSET :offset
        ");

        // Lie explicitement les paramètres pour éviter les erreurs de type
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);

        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, Post::class) ?: [];
    }


    public function countAll(): int
    {
        $query = $this->requete("SELECT COUNT(*) as total FROM {$this->table}");
        return (int) $query->fetch()['total'];
    }

    public function findPaginatedByUser(int $userId, int $limit, int $offset): array
    {
        $query = $this->db->prepare("
        SELECT * FROM {$this->table}
        WHERE user_id = :user_id
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ");

        // Liez explicitement les paramètres en tant qu'entiers
        $query->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);

        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, Post::class) ?: [];
    }

    public function countByUser(int $userId): int
    {
        $query = $this->requete("
        SELECT COUNT(*) as total 
        FROM {$this->table} 
        WHERE user_id = :user_id
    ", ['user_id' => (int) $userId]);

        return (int) $query->fetch()['total'];
    }
}
