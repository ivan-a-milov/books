<?php

namespace App\Repository\Domain;


use App\Entity\Book;

interface BookRepositoryInterface
{
    public function add(Book $book);
}
