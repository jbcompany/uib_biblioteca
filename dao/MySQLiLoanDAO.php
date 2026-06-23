<?php

namespace App\DAO;

require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/LoanDAO.php';

use App\Models\Loan;

class MySQLiLoanDAO implements LoanDAO
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function findAll(): array
    {
        $sql = 'SELECT id, user_name, university_degree, book_name, loan_date, return_date FROM loans ORDER BY id DESC';
        $result = $this->conn->query($sql);

        if (!$result) {
            return [];
        }

        $loans = [];
        while ($row = $result->fetch_assoc()) {
            $loans[] = Loan::fromArray($row);
        }

        return $loans;
    }

    public function findById(int $id)
    {
        $sql = 'SELECT id, user_name, university_degree, book_name, loan_date, return_date FROM loans WHERE id = ?';
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

        return $row ? Loan::fromArray($row) : null;
    }

    public function save(Loan $loan): bool
    {
        $sql = 'INSERT INTO loans (user_name, university_degree, book_name, loan_date, return_date) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $userName = $loan->getUserName();
        $universityDegree = $loan->getUniversityDegree();
        $bookName = $loan->getBookName();
        $loanDate = $loan->getLoanDate();
        $returnDate = $loan->getReturnDate();

        $stmt->bind_param('sssss', $userName, $universityDegree, $bookName, $loanDate, $returnDate);
        $ok = $stmt->execute();

        if ($ok) {
            $loan->setId($this->conn->insert_id);
        }

        $stmt->close();

        return $ok;
    }

    public function update(Loan $loan): bool
    {
        $sql = 'UPDATE loans SET user_name = ?, university_degree = ?, book_name = ?, loan_date = ?, return_date = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $id = (int) $loan->getId();
        $userName = $loan->getUserName();
        $universityDegree = $loan->getUniversityDegree();
        $bookName = $loan->getBookName();
        $loanDate = $loan->getLoanDate();
        $returnDate = $loan->getReturnDate();

        $stmt->bind_param('sssssi', $userName, $universityDegree, $bookName, $loanDate, $returnDate, $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM loans WHERE id = ?';
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
