<?php

namespace App\DTO;

use App\Exception\BadFileException;

class BookInfo
{
    private $title;

    private $language;

    private $authorName;

    /**
     * BookInfo constructor.
     * @param string $title
     * @param string $language
     * @param string $authorName
     * @throws BadFileException
     */
    public function __construct(string $title, string $language, string $authorName)
    {
        if (!$title) {
            throw new BadFileException('File have no book title');
        }
        if (!$authorName) {
            throw new BadFileException('File have no book author');
        }
        $this->title = $title;
        $this->language = $language;
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function language(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function authorName(): string
    {
        return $this->authorName;
    }
}
