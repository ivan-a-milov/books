<?php

namespace App\Services\Application;

use App\DTO\Request\AddBookRequest;
use App\Entity\Author;
use App\Entity\Book;
use App\Repository\Domain\AuthorRepositoryInterface;
use App\Repository\Domain\BookRepositoryInterface;
use App\Services\Domain\AbstractReaderFactory;
use Doctrine\ORM\EntityManagerInterface;

class AddBook
{
    /** @var AbstractReaderFactory  */
    private $factory;

    /** @var AuthorRepositoryInterface  */
    private $authorRepository;

    /** @var BookRepositoryInterface  */
    private $bookRepository;

    /** @var EntityManagerInterface  */
    private $entityManager;

    public function __construct(
        AbstractReaderFactory $factory,
        AuthorRepositoryInterface $authorRepository,
        BookRepositoryInterface $bookRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->factory = $factory;
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
        $this->entityManager = $entityManager;
    }

    public function execute(AddBookRequest $request): void
    {
        $reader = $this->factory->getReader($request->content());
        $bookInfo = $reader->readInfo($request->content());
        $author = $this->authorRepository->findByName($bookInfo->authorName());
        if (is_null($author)) {
            $author = new Author();
            $author->setName($bookInfo->authorName());
            $this->authorRepository->add($author);
        }

        $book = new Book();
        $book->setTitle($bookInfo->title())
            ->setLanguage($bookInfo->language())
            ->setAuthor($author);
        $this->bookRepository->add($book);
        $this->entityManager->flush();
    }
}
