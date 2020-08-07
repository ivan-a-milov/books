<?php

namespace App\Tests\Services\Domain;


trait ExampleFilesTrait
{
    /**
     * @param string $fileName
     * @return string
     *
     *  FIXME жуткий костыль !!!
     */
    private function getFileContent(string $fileName): string
    {
        $filePath = dirname(__FILE__) . '/../../files/' . $fileName;
        return file_get_contents($filePath);
    }
}
