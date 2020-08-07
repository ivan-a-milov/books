<?php

namespace App\Services\Domain;

class FinfoTypeRecognizer implements TypeRecognizer
{
    public function recognize(string $content): string
    {
        $typeMap = [
            'text/xml' => self::TYPE_FB2,
            'application/epub+zip' => self::TYPE_EPUB,
        ];
        $type = self::TYPE_UNKNOWN;

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $finfoType = $finfo->buffer($content);

        if (array_key_exists($finfoType, $typeMap)) {
            $type = $typeMap[$finfoType];
        }

        return $type;
    }
}
