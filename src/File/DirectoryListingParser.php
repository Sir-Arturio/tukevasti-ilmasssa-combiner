<?php

namespace TukevastiIlmassaDataCombiner\File;

Use DateTime;

class DirectoryListingParser
{
    public function parse($fileData) {
        $files = array_filter($fileData, function ($file) { return preg_match('|.mp3$|', $file); });
        $file_data = array_map(array($this, "process_file"), $files);
        return array_values($file_data);
    }

    protected function process_file($filename) {
        return array($filename, $this->get_date_from_filename($filename));
    }

    protected function get_date_from_filename($filename) {
        $exceptions = array('201306010' => '20130610');

        preg_match("/^[0-9]+/", $filename, $matches);
        $dateStr = (isset($matches)) ? current($matches) : false;

        if(array_key_exists($dateStr, $exceptions)) {
            echo "CONVERTING DATE FROM: '" . $dateStr . "' ";
            $dateStr = $exceptions[$dateStr];
            echo "TO: '". $dateStr ."'\n";
        }

        $date = DateTime::createFromFormat("Ymd H:i:s", $dateStr . " 00:00:00");
        if(!is_object($date)) {
            echo "ERROR CONVERTING '" . $dateStr . "'";
        }
        $date = is_object($date) ? $date->format("Y-m-d") : '0000-00-00';
        return $date;
        //return DateTime::createFromFormat("Ymd H:i:s", $dateStr . " 00:00:00")->format("Y-m-d");
    }
} 
