<?php

namespace App\Repository\Domain;


use App\Entity\Author;

interface AuthorRepositoryInterface
{
    public function findByName(string $authorName): ?Author;
    public function add(Author $author);
}
