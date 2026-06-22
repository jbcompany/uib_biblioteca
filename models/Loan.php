<?php

namespace App\Models;

class Loan
{
    private $id;
    private $userName;
    private $bookName;
    private $universityDegree;

    private $loanDate;
    private $returnDate;

    public function __construct($id = null, $userName = null, $bookName = null, $universityDegree = null, $loanDate = null, $returnDate = null)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->bookName = $bookName;
        $this->universityDegree = $universityDegree;
        $this->loanDate = $loanDate;
        $this->returnDate = $returnDate;
    }

    public static function fromArray(array $row)
    {
        return new self(
            isset($row['id']) ? (int) $row['id'] : null,
            isset($row['user_name']) ? $row['user_name'] : null,
            isset($row['book_name']) ? $row['book_name'] : null,
            isset($row['university_degree']) ? $row['university_degree'] : null,
            isset($row['loan_date']) ? $row['loan_date'] : null,
            isset($row['return_date']) ? $row['return_date'] : null
        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'user_name' => $this->userName,
            'book_name' => $this->bookName,
            'university_degree' => $this->universityDegree,
            'loan_date' => $this->loanDate,
            'return_date' => $this->returnDate,
        ];
    }

    // Getters and setters...
    public function getId()
    {
        return $this->id;
    }   

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getBookName()
    {
        return $this->bookName;
    }

    public function setBookName($bookName)
    {
        $this->bookName = $bookName;
    }

    public function getUniversityDegree()
    {
        return $this->universityDegree;
    }

    public function setUniversityDegree($universityDegree)
    {
        $this->universityDegree = $universityDegree;
    } 
    public function getLoanDate()
    {
        return $this->loanDate;
    }
    public function setLoanDate($loanDate)
    {
        $this->loanDate = $loanDate;
    }
    public function getReturnDate()
    {
        return $this->returnDate;
    }
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;
    }

}
?>