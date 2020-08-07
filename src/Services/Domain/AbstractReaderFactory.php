<?php

namespace App\Services\Domain;

interface AbstractReaderFactory
{
    public function getReader(string $content): Reader;
}
