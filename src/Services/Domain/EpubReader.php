<?php

namespace App\Services\Domain;


use App\DTO\BookInfo;

class EpubReader extends AbstractXmlReader implements Reader
{
    /**
     * @param string $content
     * @return BookInfo
     * @throws \App\Exception\BadFileException
     */
    public function readInfo(string $content): BookInfo
    {

        $this->init($content);

        $title = $this->queryFirst('//e:package/e:metadata/dc:title');
        $authorName = $this->queryFirst('//e:package/e:metadata/dc:creator');
        $language = $this->queryFirst('//e:package/e:metadata/dc:language');

        return new BookInfo($title, $language, $authorName);
    }

    protected function init(string $content): void
    {
        $tmpFile = tmpfile();
        $metadata = stream_get_meta_data($tmpFile);
        $fileName = $metadata['uri'];
        file_put_contents($fileName, $content);

        $zip = new \ZipArchive();
        $zip->open($fileName);
        $fp = $zip->getStream('OEBPS/content.opf');
        $xml = stream_get_contents($fp);
        fclose($fp);

        parent::init($xml);

        $this->xpath->registerNamespace('e', 'http://www.idpf.org/2007/opf');
    }
}
