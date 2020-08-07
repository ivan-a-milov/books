<?php

namespace App\Tests\Services\Domain;

use App\Exception\BadFileException;
use App\Services\Domain\Fb2Reader;
use PHPUnit\Framework\TestCase;

class Fb2ReaderTest extends TestCase
{
    use ExampleFilesTrait;

    public function testOK()
    {
        $reader = new Fb2Reader();
        $bookInfo = $reader->readInfo($this->getFileContent('example.fb2'));

        $this->assertEquals('example 314159265', $bookInfo->title());
        $this->assertEquals('en', $bookInfo->language());
        $this->assertEquals('Frederick Pohl', $bookInfo->authorName());
    }

    public function testNoTitle()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<FictionBook xmlns="http://www.gribuser.ru/xml/fictionbook/2.0" xmlns:xlink="http://www.w3.org/1999/xlink">
    <description>
        <title-info>
            <author>
              <first-name>Frederick</first-name>
              <last-name>Pohl</last-name>
            </author>
            <genre>antique</genre>
            <coverpage><image xlink:href="#_0.jpg"/></coverpage>
            <lang>en</lang>
        </title-info>
    </description>
</FictionBook>
XML;
        $reader = new Fb2Reader();
        $this->expectException(BadFileException::class);
        $reader->readInfo($xml);
    }

    public function testNoAuthor()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<FictionBook xmlns="http://www.gribuser.ru/xml/fictionbook/2.0" xmlns:xlink="http://www.w3.org/1999/xlink">
    <description>
        <title-info>
            <book-title>example 314159265</book-title>
            <genre>antique</genre>
            <coverpage><image xlink:href="#_0.jpg"/></coverpage>
            <lang>en</lang>
        </title-info>
    </description>
</FictionBook>
XML;
        $reader = new Fb2Reader();
        $this->expectException(BadFileException::class);
        $reader->readInfo($xml);
    }
}
