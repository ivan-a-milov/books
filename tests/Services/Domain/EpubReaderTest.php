<?php

namespace App\Tests\Services\Domain;

use App\Services\Domain\EpubReader;
use PHPUnit\Framework\TestCase;

class EpubReaderTest extends TestCase
{
    use ExampleFilesTrait;

    public function testOK()
    {
        $reader = new EpubReader();
        $bookInfo = $reader->readInfo($this->getFileContent('example.epub'));

        $expectedTitle = 'The Gun Alley Tragedy / Record of the Trial of Colin Campbell Ross';
        $this->assertEquals($expectedTitle, $bookInfo->title());
        $this->assertEquals('en', $bookInfo->language());
        $this->assertEquals('T. C. Brennan', $bookInfo->authorName());
    }
}
