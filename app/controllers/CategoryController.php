<?php

namespace App\Models;

use App\Core\Db;

abstract class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }
}
