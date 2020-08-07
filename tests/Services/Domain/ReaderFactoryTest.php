<?php
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpParamsInspection */

namespace App\Tests\Services\Domain;

use App\Exception\UnknownFileFormat;
use App\Services\Domain\EpubReader;
use App\Services\Domain\Fb2Reader;
use App\Services\Domain\ReaderFactory;
use App\Services\Domain\TypeRecognizer;
use PHPUnit\Framework\TestCase;

class ReaderFactoryTest extends TestCase
{
    public function testSomething()
    {
        $this->assertTrue(true);
    }

    public function testGetReaderFb2()
    {
        $this->_testGetReader(TypeRecognizer::TYPE_FB2, Fb2Reader::class);

    }

    public function testGetReaderEpub()
    {
        $this->_testGetReader(TypeRecognizer::TYPE_EPUB, EpubReader::class);
    }

    public function testGetReaderUnknown()
    {
        $recognizer = $this->createMock(TypeRecognizer::class);
        $recognizer->expects($this->once())
            ->method('recognize')
            ->will($this->returnValue(TypeRecognizer::TYPE_UNKNOWN))
        ;

        $factory = new ReaderFactory($recognizer);

        $this->expectException(UnknownFileFormat::class);
        $factory->getReader('stub content');
    }


    private function _testGetReader($type, $className)
    {
        $recognizer = $this->createMock(TypeRecognizer::class);
        $recognizer->expects($this->once())
            ->method('recognize')
            ->will($this->returnValue($type))
        ;

        $factory = new ReaderFactory($recognizer);
        $reader = $factory->getReader('stub content');

        $this->assertEquals($className, get_class($reader), 'Factory should return ' . $className);
    }
}
