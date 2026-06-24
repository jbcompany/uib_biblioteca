<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\DAO\MySQLiBookDAO;
use App\Models\Book;
use PHPUnit\Framework\TestCase;

class MySQLiBookDAOTest extends TestCase
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
            self::markTestSkipped('No se pudo conectar a la BD de test: ' . $this->conn->connect_error);
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
        $dao = new MySQLiBookDAO($this->conn);

        $book = new Book(
            null,
            'TDD by Example',
            'Kent Beck',
            2002,
            'Software',
            'TEST-SHELF'
        );

        $saved = $dao->save($book);
        $this->assertTrue($saved);
        $this->assertNotNull($book->getId());

        $found = $dao->findById((int) $book->getId());
        $this->assertNotNull($found);
        $this->assertSame('TDD by Example', $found->getTitle());

        $deleted = $dao->delete((int) $book->getId());
        $this->assertTrue($deleted);
    }
}
