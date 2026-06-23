<?php

namespace App\Models;

class Book
{
    private ?int $id;
    private string $title;
    private string $author;
    private int $publishedYear;
    private string $genre;
    private string $ubication;

    public function __construct(?int $id = null, string $title = '', string $author = '', int $publishedYear = 0, string $genre = '', string $ubication = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->publishedYear = $publishedYear;
        $this->genre = $genre;
        $this->ubication = $ubication;
    }

    public static function fromArray(array $row): self
    {
        return new self(
            isset($row['id']) ? (int) $row['id'] : null,
            isset($row['title']) ? $row['title'] : '',
            isset($row['author']) ? $row['author'] : '',
            isset($row['published_year']) ? (int) $row['published_year'] : 0,
            isset($row['genre']) ? $row['genre'] : '',
            isset($row['ubication']) ? $row['ubication'] : ''
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'published_year' => $this->publishedYear,
            'genre' => $this->genre,
            'ubication' => $this->ubication,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }


    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function getPublishedYear(): int
    {
        return $this->publishedYear;
    }

    public function setPublishedYear(int $publishedYear)
    {
        $this->publishedYear = $publishedYear;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre)
    {
        $this->genre = $genre;
    }

    public function getUbication(): string
    {
        return $this->ubication;
    }

    public function setUbication(string $ubication)
    {
        $this->ubication = $ubication;
    }
}
