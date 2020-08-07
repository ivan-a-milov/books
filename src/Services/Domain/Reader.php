<?php

namespace App\Services\Domain;

use App\DTO\BookInfo;

interface Reader
{
    public function readInfo(string $content): BookInfo;
}
