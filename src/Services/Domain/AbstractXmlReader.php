<?php

namespace App\Services\Domain;


class AbstractXmlReader
{
    /** @var \DOMXPath */
    protected $xpath;

    protected function queryFirst(string $query): string
    {
        $result = '';
        /** @var \DOMNameList $entries */
        $entries = $this->xpath->query($query);
        /** @var \DOMNode $entry */
        $entry = $entries[0];
        if ($entry) {
            $result = $entry->textContent;
        }

        return $result;
    }

    protected function init(string $content): void
    {
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->loadXML($content);
        $this->xpath = new \DOMXPath($doc);
    }

}
