<?php

namespace App\Models;

class Book
{
    private $id;
    private $title;
    private $author;
    private $publishedYear;
    private $genre;
    private $ubication;

    public function __construct($id = null, $title = '', $author = '', $publishedYear = 0, $genre = '', $ubication = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->publishedYear = $publishedYear;
        $this->genre = $genre;
        $this->ubication = $ubication;
    }

    public static function fromArray(array $row)
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

    public function toArray()
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
    

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getPublishedYear()
    {
        return $this->publishedYear;
    }

    public function setPublishedYear($publishedYear)
    {
        $this->publishedYear = (int) $publishedYear;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function getUbication()
    {
        return $this->ubication;
    }

    public function setUbication($ubication)
    {
        $this->ubication = $ubication;
    }
}
