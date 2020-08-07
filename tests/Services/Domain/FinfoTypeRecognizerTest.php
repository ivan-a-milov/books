<?php

namespace App\Tests\Services\Domain;

use App\Services\Domain\FinfoTypeRecognizer;
use App\Services\Domain\TypeRecognizer;
use PHPUnit\Framework\TestCase;

class FinfoTypeRecognizerTest extends TestCase
{
    use ExampleFilesTrait;

    public function testFb2()
    {
        $this->_testType(TypeRecognizer::TYPE_FB2, 'example.fb2');
    }

    public function testEpub()
    {
        $this->_testType(TypeRecognizer::TYPE_EPUB, 'example.epub');
    }

    public function testUnknown()
    {
        $this->_testType(TypeRecognizer::TYPE_UNKNOWN, 'Kernel.php');
    }

    private function _testType(string $expectedType, string $fileName)
    {
        $recognizer = new FinfoTypeRecognizer();
        $content = $this->getFileContent($fileName);
        $this->assertEquals($expectedType, $recognizer->recognize($content));
    }
}
