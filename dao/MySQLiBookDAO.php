<?php

namespace App\DAO;

require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/BookDAO.php';

use App\Models\Book;

class MySQLiBookDAO implements BookDAO
{
    private $conn;

    public function __construct(\mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function findAll()
    {
        $sql = 'SELECT id, title, author, published_year, genre, ubication FROM books ORDER BY id DESC';
        $result = $this->conn->query($sql);

        if (!$result) {
            return [];
        }

        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = Book::fromArray($row);
        }

        return $books;
    }

    public function findById($id)
    {
        $sql = 'SELECT id, title, author, published_year, genre, ubication FROM books WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $id = (int) $id;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        $stmt->close();

        return $row ? Book::fromArray($row) : null;
    }

    public function save(Book $book)
    {
        $sql = 'INSERT INTO books (title, author, published_year, genre, ubication) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $title = $book->getTitle();
        $author = $book->getAuthor();
        $publishedYear = $book->getPublishedYear();
        $genre = $book->getGenre();
        $ubication = $book->getUbication();

        $stmt->bind_param('ssiss', $title, $author, $publishedYear, $genre, $ubication);
        $ok = $stmt->execute();

        if ($ok) {
            $book->setId($this->conn->insert_id);
        }

        $stmt->close();

        return $ok;
    }

    public function update(Book $book)
    {
        $sql = 'UPDATE books SET title = ?, author = ?, published_year = ?, genre = ?, ubication = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $id = (int) $book->getId();
        $title = $book->getTitle();
        $author = $book->getAuthor();
        $publishedYear = $book->getPublishedYear();
        $genre = $book->getGenre();
        $ubication = $book->getUbication();

        $stmt->bind_param('ssissi', $title, $author, $publishedYear, $genre, $ubication, $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM books WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $id = (int) $id;
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
