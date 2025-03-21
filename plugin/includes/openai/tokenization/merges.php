<?php

class AIKIT_Merges {
    private string $path;
    public function __construct(string $path = __DIR__ . '/files/merges.txt')
    {
        $this->path = $path;
    }

    public function bpeMerges(): array
    {
        $lines = [];
        $fp = @fopen($this->path, "r");
        if ($fp) {
            // drop the first line of the buffer
            fgets($fp, 300);
            while (($buffer = fgets($fp, 300)) !== false) {
                $line = array_filter(preg_split("/(\s+)/", $buffer), function($e) {
                    return strlen(trim($e)) > 0;
                });
                $lines[] = $line;
            }
            if (!feof($fp)) {
                throw new Exception("Error: unexpected fgets() fail\n");
            }
            fclose($fp);
        }
        return $lines;
    }
}
