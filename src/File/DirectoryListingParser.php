<?php

namespace TukevastiIlmassaDataCombiner\File;

Use DateTime;

class DirectoryListingParser
{
    /**
     * Parse an array of files into an array of file data. Only MP3 files are processed. Others are omitted.
     *
     * @param array $fileData An array containing files array('.', '..', 'Tukevasti Ilmassa 2015-09-11.mp3');
     * @return FileData[]
     */
    public function parse(array $fileData) {
        $files = array_filter($fileData, function ($file) { return preg_match('|.mp3$|', $file); });
        $file_data = array_map(array($this, "processFile"), $files);
        return array_values($file_data);
    }

    /**
     * @param string $fileName
     * @return FileData
     */
    protected function processFile($fileName) {
        return new FileData($fileName, $this->getDateFromFileName($fileName));
    }

    /**
     * @param $fileName
     * @return DateTime|null
     */
    protected function getDateFromFileName($fileName) {
        $exceptions = array('201306010' => '20130610');

        preg_match("/^[0-9]+/", $fileName, $matches);
        $dateStr = (isset($matches)) ? current($matches) : false;
        if($dateStr === false) {
            return null;
        }

        if(array_key_exists($dateStr, $exceptions)) {
            echo "CONVERTING DATE FROM: '" . $dateStr . "' ";
            $dateStr = $exceptions[$dateStr];
            echo "TO: '". $dateStr ."'\n";
        }

        $date = DateTime::createFromFormat("Ymd H:i:s", $dateStr . " 00:00:00");
        if(!is_object($date)) {
            echo "ERROR CONVERTING '" . $dateStr . "'";
        }
        $date = is_object($date) ? $date : null;
        return $date;
    }
} 
