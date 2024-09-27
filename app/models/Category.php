<?php

namespace App\Models;

class Category extends Model
{
    private $id;
    private $name;

    // Getters et setters

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // Méthodes CRUD

    public function save()
    {
        if ($this->id) {
            // Mise à jour
            $stmt = $this->db->prepare("UPDATE category SET name = :name WHERE id = :id");
            $stmt->execute([
                'name' => $this->name,
                'id' => $this->id
            ]);
        } else {
            // Insertion
            $stmt = $this->db->prepare("INSERT INTO category (name) VALUES (:name)");
            $stmt->execute(['name' => $this->name]);
            $this->id = $this->db->lastInsertId();
        }
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function getAll()
    {
        $db = Db::getInstance();
        $stmt = $db->query("SELECT * FROM category");
        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public function delete()
    {
        if ($this->id) {
            $stmt = $this->db->prepare("DELETE FROM category WHERE id = :id");
            $stmt->execute(['id' => $this->id]);
        }
    }
}
