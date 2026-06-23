<?php
require_once __DIR__ . '/models/Loan.php';
require_once __DIR__ . '/dao/LoanDAO.php';
require_once __DIR__ . '/dao/MySQLiLoanDAO.php';

use App\Models\Loan;
use App\DAO\MySQLiLoanDAO;

class LoansService
{
    private MySQLiLoanDAO $loanDAO;

    public function __construct(\mysqli $conn)
    {
        $this->loanDAO = new MySQLiLoanDAO($conn);
    }

    public function getAllLoans()
    {
        return $this->loanDAO->findAll();
    }

    public function getLoanById(int$id)
    {
        return $this->loanDAO->findById($id);
    }

    public function createLoan(Loan $loan)
    {
        return $this->loanDAO->save($loan);
    }

    public function updateLoan(Loan $loan)
    {
        return $this->loanDAO->update($loan);
    }

    public function deleteLoan(int $id)
    {
        return $this->loanDAO->delete($id);
    }
}

