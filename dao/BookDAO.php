<?php

namespace App\DAO;

use App\Models\Book;

require_once __DIR__ . '/../models/Book.php';

interface BookDAO
{
    public function findAll(): array;

    public function findById(int $id);

    public function save(Book $book);

    public function update(Book $book);

    public function delete(int $id);
}
