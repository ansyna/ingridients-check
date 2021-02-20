<?php


namespace App\Services;


class CsvParser
{
    public function readCSV($csvFile, $array)
    {
        $lines = [];
        $handle = fopen($csvFile, 'r');
        while (!feof($handle)) {
            $lines[] = fgetcsv($handle, 0, $array['delimiter']);
        }
        fclose($handle);

        return $lines;
    }
}
