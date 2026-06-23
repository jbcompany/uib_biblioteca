<?php
require_once __DIR__ . '/models/Book.php';
require_once __DIR__ . '/dao/BookDAO.php';
require_once __DIR__ . '/dao/MySQLiBookDAO.php';

use App\Models\Book;
use App\DAO\MySQLiBookDAO;

class BooksService
{
    private MySQLiBookDAO $bookDAO;

    public function __construct(\mysqli $conn)
    {
        $this->bookDAO = new MySQLiBookDAO($conn);
    }

    public function getAllBooks()
    {
        return $this->bookDAO->findAll();
    }

    public function getBookById(int $id)
    {
        return $this->bookDAO->findById($id);
    }

    public function createBook(Book $book)
    {
        return $this->bookDAO->save($book);
    }

    public function updateBook(Book $book)
    {
        return $this->bookDAO->update($book);
    }

    public function deleteBook(int $id)
    {
        return $this->bookDAO->delete($id);
    }
}
