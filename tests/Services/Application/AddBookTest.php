<?php
/** @noinspection PhpParamsInspection */

namespace App\Tests\Services\Application;

use App\DTO\BookInfo;
use App\DTO\Request\AddBookRequest;
use App\Repository\Domain\AuthorRepositoryInterface;
use App\Repository\Domain\BookRepositoryInterface;
use App\Services\Application\AddBook;
use App\Services\Domain\AbstractReaderFactory;
use App\Services\Domain\Reader;
use PHPUnit\Framework\TestCase;

class AddBookTest extends TestCase
{
    public function testExecuteNewAuthor()
    {
        $content = 'stub content';

        $bookInfo = new BookInfo(
            'Hamlet', 'en', 'William Shakespeare'
        );

        $reader = $this->createMock(Reader::class);
        $reader->expects($this->once())
            ->method('readInfo')
            ->will($this->returnValue($bookInfo));

        $factory = $this->createMock(AbstractReaderFactory::class);
        $factory->expects($this->once())
            ->method('getReader')
            ->will($this->returnValue($reader))
        ;

        $authorRepository = $this->createMock(AuthorRepositoryInterface::class);
        $authorRepository->expects($this->once())
            ->method('findByName')
            ->with($bookInfo->authorName())
            ->will($this->returnValue(null))
        ;

        // TODO check argument
        $authorRepository->expects($this->once())
            ->method('add')
        ;

        $bookRepository = $this->createMock(BookRepositoryInterface::class);
        // TODO check argument
        $bookRepository->expects($this->once())
            ->method('add')
        ;

        $service = new AddBook($factory, $authorRepository, $bookRepository);
        $request = new AddBookRequest($content);
        $service->execute($request);
    }
}
