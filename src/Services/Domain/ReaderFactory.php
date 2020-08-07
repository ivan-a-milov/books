<?php

namespace App\Services\Domain;


use App\Exception\UnknownFileFormat;

class ReaderFactory implements AbstractReaderFactory
{
    private $typeRecognizer;

    public function __construct(TypeRecognizer $typeRecognizer)
    {
        $this->typeRecognizer = $typeRecognizer;
    }


    /**
     * @param string $content
     * @return Reader
     * @throws UnknownFileFormat
     */
    public function getReader(string $content): Reader
    {
        $type = $this->typeRecognizer->recognize($content);
        switch ($type) {
            case TypeRecognizer::TYPE_FB2:
                return new Fb2Reader();
                break;
            case TypeRecognizer::TYPE_EPUB:
                return new EpubReader();
                break;
            default:
                throw new UnknownFileFormat('Unknown file format');
        }
   }
}
