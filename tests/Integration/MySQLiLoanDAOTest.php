<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\DAO\MySQLiLoanDAO;
use App\Models\Loan;
use PHPUnit\Framework\TestCase;

class MySQLiLoanDAOTest extends TestCase
{
    private ?\mysqli $conn = null;

    protected function setUp(): void
    {
        if (!extension_loaded('mysqli')) {
            self::markTestSkipped('La extension mysqli no esta disponible.');
        }

        $host = getenv('TEST_DB_HOST') ?: '127.0.0.1';
        $user = getenv('TEST_DB_USER') ?: 'root';
        $pass = getenv('TEST_DB_PASS') ?: '';
        $name = getenv('TEST_DB_NAME') ?: '';

        if ($name === '') {
            self::markTestSkipped('Define TEST_DB_NAME para ejecutar pruebas de integracion.');
        }

        $this->conn = new \mysqli($host, $user, $pass, $name);
        if ($this->conn->connect_error) {
            self::markTestSkipped('No se pudo conectar a la base de datos de prueba: ' . $this->conn->connect_error);
        }
    }
    protected function tearDown(): void
    {
        if ($this->conn instanceof \mysqli) {
            $this->conn->close();
        }
    }

    public function testSaveAndFindById(): void
    {
        $dao = new MySQLiLoanDAO($this->conn);

        $loan = new Loan(
            null,
            "test user", // user_name
            "test book", // book_name
            "test_university_degree", // university_degree
            '2024-01-01', // loan_date
            '2024-01-15'  // return_date
        );

        $saved = $dao->save($loan);
        $this->assertTrue($saved);
        $this->assertNotNull($loan->getId());

        $foundLoan = $dao->findById($loan->getId());
        $this->assertNotNull($foundLoan);
        $this->assertSame($loan->getUserName(), $foundLoan->getUserName());
        $this->assertSame($loan->getBookName(), $foundLoan->getBookName());
        $this->assertSame($loan->getUniversityDegree(), $foundLoan->getUniversityDegree());
        $this->assertSame($loan->getLoanDate(), $foundLoan->getLoanDate());
        $this->assertSame($loan->getReturnDate(), $foundLoan->getReturnDate());

        $deleted = $dao->delete($loan->getId());
        $this->assertTrue($deleted);

        $foundLoan = $dao->findById($loan->getId());
        $this->assertNull($foundLoan);
    }

    public function testUpdatePersistsModifiedLoanData(): void
    {
        $dao = new MySQLiLoanDAO($this->conn);

        $loan = new Loan(
            null,
            "test user",
            "test book",
            "test_university_degree",
            '2024-01-01',
            '2024-01-15'
        );

        $saved = $dao->save($loan);
        $this->assertTrue($saved);
        $this->assertNotNull($loan->getId());

        // Modify the loan data
        $loan->setUserName("updated user");
        $loan->setBookName("updated book");
        $loan->setUniversityDegree("updated_university_degree");
        $loan->setLoanDate('2024-02-01');
        $loan->setReturnDate('2024-02-15');

        $updated = $dao->update($loan);
        $this->assertTrue($updated);

        // Retrieve the updated loan from the database
        $foundLoan = $dao->findById($loan->getId());
        $this->assertNotNull($foundLoan);
        $this->assertSame("updated user", $foundLoan->getUserName());
        $this->assertSame("updated book", $foundLoan->getBookName());
        $this->assertSame("updated_university_degree", $foundLoan->getUniversityDegree());
        $this->assertSame('2024-02-01', $foundLoan->getLoanDate());
        $this->assertSame('2024-02-15', $foundLoan->getReturnDate());

        // Clean up by deleting the loan
        $deleted = $dao->delete($loan->getId());
        $this->assertTrue($deleted);
    }

}