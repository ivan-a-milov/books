<?php

namespace App\Services\Domain;

use App\DTO\BookInfo;

class Fb2Reader extends AbstractXmlReader implements Reader
{
    private $queryPrefix = '//fb2:FictionBook/fb2:description/fb2:title-info/';

    /**
     * @param string $content
     * @return BookInfo
     * @throws \App\Exception\BadFileException
     */
    public function readInfo(string $content): BookInfo
    {
        $this->init($content);

        $title = $this->queryFirst($this->queryPrefix . 'fb2:book-title');
        $language = $this->queryFirst($this->queryPrefix . 'fb2:lang');
        $authorName = $this->readAuthorName();

        return new BookInfo($title, $language, $authorName);
    }

    private function readAuthorName(): string
    {
        $authorNames = [];
        $firstName = $this->queryFirst($this->queryPrefix . 'fb2:author/fb2:first-name');
        if ($firstName) {
            $authorNames[] = $firstName;
        }

        $lastName = $this->queryFirst($this->queryPrefix . 'fb2:author/fb2:last-name');
        if ($lastName) {
            $authorNames[] = $lastName;
        }

        return implode(' ', $authorNames);
    }

    protected function init(string $content): void
    {
        parent::init($content);
        $this->xpath->registerNamespace('fb2', 'http://www.gribuser.ru/xml/fictionbook/2.0');
    }
}
