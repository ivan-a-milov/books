<?php

namespace App\DTO\Request;

class AddBookRequest
{
    /** @var string */
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }
}
