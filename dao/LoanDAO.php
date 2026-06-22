<?php
namespace App\DAO;

use App\Models\Loan;

require_once __DIR__ . '/../models/Loan.php';

interface LoanDAO
{
    public function findAll();

    public function findById($id);

    public function save(Loan $loan);

    public function update(Loan $loan);

    public function delete($id);
}
?>