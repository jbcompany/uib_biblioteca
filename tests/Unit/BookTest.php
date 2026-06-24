<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testCanCreateBookAndReadFields(): void
    {
        $book = new Book(
            null,
            'Clean Code',
            'Robert C. Martin',
            2008,
            'Software',
            'A1'
        );

        $this->assertNull($book->getId());
        $this->assertSame('Clean Code', $book->getTitle());
        $this->assertSame('Robert C. Martin', $book->getAuthor());
        $this->assertSame(2008, $book->getPublishedYear());
        $this->assertSame('Software', $book->getGenre());
        $this->assertSame('A1', $book->getUbication());
    }

    public function testFromArrayAndToArrayRoundTrip(): void
    {
        $row = [
            'id' => 10,
            'title' => 'Refactoring',
            'author' => 'Martin Fowler',
            'published_year' => 1999,
            'genre' => 'Software',
            'ubication' => 'B2',
        ];

        $book = Book::fromArray($row);
        $this->assertSame($row, $book->toArray());
    }
}
