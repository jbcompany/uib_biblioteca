<?php

namespace App\Models;

class Loan
{
    private ?int $id;
    private ?string $userName;
    private ?string $bookName;
    private ?string $universityDegree;

    private ?string $loanDate;
    private ?string $returnDate;

    public function __construct(?int $id = null, ?string $userName = null, ?string $bookName = null, ?string $universityDegree = null, ?string $loanDate = null, ?string $returnDate = null)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->bookName = $bookName;
        $this->universityDegree = $universityDegree;
        $this->loanDate = $loanDate;
        $this->returnDate = $returnDate;
    }

    public static function fromArray(array $row): self
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

    public function toArray(): array
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
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName)
    {
        $this->userName = $userName;
    }

    public function getBookName(): ?string
    {
        return $this->bookName;
    }

    public function setBookName(?string $bookName)
    {
        $this->bookName = $bookName;
    }

    public function getUniversityDegree(): ?string
    {
        return $this->universityDegree;
    }

    public function setUniversityDegree(?string $universityDegree)
    {
        $this->universityDegree = $universityDegree;
    }
    public function getLoanDate(): ?string
    {
        return $this->loanDate;
    }
    public function setLoanDate(?string $loanDate)
    {
        $this->loanDate = $loanDate;
    }
    public function getReturnDate(): ?string
    {
        return $this->returnDate;
    }
    public function setReturnDate(?string $returnDate)
    {
        $this->returnDate = $returnDate;
    }

}
