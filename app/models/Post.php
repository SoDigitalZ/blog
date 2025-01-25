<?php

namespace App\Models;

class Post
{
    protected $id;
    protected $user_id; // Ajout de la propriété user_id
    protected $title;
    protected $chapo;
    protected $content;
    protected $image;
    protected $category_id;
    protected $created_at;
    protected $update_at;

    // Chemin relatif de l'image par défaut
    protected const DEFAULT_IMAGE = '/picture/post_image/no_image.png';

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
        // Assure qu'une image par défaut est définie si aucune n'est fournie
        if (empty($this->image)) {
            $this->setImage(null); // setImage appliquera automatiquement la valeur par défaut
        }
        // Assure qu'une valeur par défaut est définie pour category_id
        if ($this->category_id === null) {
            $this->setCategoryId(1); // ID de catégorie par défaut
        }
    }

    public function hydrate(array $data): self
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }


    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): ?int // Ajout du getter
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self // Ajout du setter
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getChapo(): ?string
    {
        return $this->chapo;
    }

    public function setChapo(string $chapo): self
    {
        $this->chapo = $chapo;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image ?: self::DEFAULT_IMAGE;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): self
    {
        $this->category_id = $category_id;
        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdateAt(): ?string
    {
        return $this->update_at;
    }

    public function setUpdateAt(string $update_at): self
    {
        $this->update_at = $update_at;
        return $this;
    }
}
