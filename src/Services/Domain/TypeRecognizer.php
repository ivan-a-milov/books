<?php

namespace App\Services\Domain;


interface TypeRecognizer
{
    public const TYPE_FB2 = 'TYPE_FB2';
    public const TYPE_EPUB = 'TYPE_EPUB';
    public const TYPE_UNKNOWN = 'TYPE_UNKNOWN';

    public function recognize(string $content): string;
}
