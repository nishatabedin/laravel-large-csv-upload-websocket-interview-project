<?php
namespace App\Services;

class CsvProcessorService
{
    public function removeNonUTF8Characters($fileContents)
    {
        $lines = str_getcsv($fileContents, "\n");
        $processedLines = [];
        
        foreach ($lines as $lineKey => $line) {
            $processedLine = iconv('UTF-8', 'UTF-8//IGNORE', $line);
            $processedLine = mb_convert_encoding($processedLine, 'UTF-8', 'UTF-8');
            $processedLine = preg_replace("/([\x{00}-\x{7E}]|[\x{C2}-\x{DF}][\x{80}-\x{BF}]|\x{E0}[\x{A0}-\x{BF}][\x{80}-\x{BF}]|[\x{E1}-\x{EC}\x{EE}\{EF}][\x{80}-\x{BF}]{2}|\x{ED}[\x{80}-\x{9F}][\x{80}-\x{BF}]|\x{F0}[\x{90}-\x{BF}][\x{80}-\x{BF}]{2}|[\x{F1}-\x{F3}][\x{80}-\x{BF}]{3}|\x{F4}[\x{80}-\x{8F}][\x{80}-\x{BF}]{2})|(.)/s", "$1", $processedLine);
            $processedLines[] = $processedLine;
        }
        return implode("\n", $processedLines);
    }
}

