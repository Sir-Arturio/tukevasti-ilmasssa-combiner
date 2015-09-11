<?php

namespace TukevastiIlmassaDataCombiner\Wiki;

use DateTime;
use Exception;

class WmlParser
{
    /**
     * Convert a Wiki page/tables in string to an array of WikiEpisodeInfos.
     *
     * @param string $rawData Wiki page/tables as a string.
     * @return WikiEpisodeInfo[]
     */
    public function parse($rawData)
    {
        $content = str_replace(array("[[", "]]", "&nbsp;"), '', $rawData);
        $content = preg_replace('/!\|/m', '||', $content);
        $matches = preg_split('/\|-|{\|/', $content);

        foreach ($matches as &$row) {
            $cells = explode("\n", $row);
            $cells = array_filter($cells, function ($cell) { return preg_match('/\|\|/', $cell); });
            $cells = preg_replace('/\|\|\s*/', '', $cells);
            if (isset($cells[1]) && count($cells) >= 3) {
                $date = NULL;
                try {
                    $date = $this->convertFinnishDateStringIntoDateTime($cells[1]);
                }
                catch(Exception $e) {}
                $cells[1] = $date;
            }
            $row = $cells;
        }

        $matches = array_filter($matches);
        $matches = array_filter($matches, function($a) { return (is_object($a[1])) ? true : false; });
        $matches = array_filter($matches, function($a) { return ($a[2] == 'Uusinta edellisestä') ? false : true; });
        usort($matches, array($this, 'sortByDate'));
        $matches = array_map(array($this, 'convertArrayToWikiEpisodeInfo'), $matches);

        return $matches;
    }

    /**
     * Convert an array to an WikiEpisodeInfo object.
     *
     * @param array $item
     * @return WikiEpisodeInfo
     */
    protected function convertArrayToWikiEpisodeInfo(array $item) {
        return new WikiEpisodeInfo(
            $item[1],
            $item[2],
            isset($item[3]) ? $item[3] : null,
            isset($item[4]) ? $item[4] : null
        );
    }

    protected function sortByDate($a, $b)
    {
        $a = $this->flattenDate($a[1]);
        $b = $this->flattenDate($b[1]);

        return strcmp($a, $b);
    }

    protected function flattenDate(DateTime $date)
    {
        return $date->format("Y-m-d");
    }

    /**
     * @param string $finnishDate
     * @throws Exception
     * @return DateTime
     */
    protected function convertFinnishDateStringIntoDateTime($finnishDate)
    {
        $dateParts = explode(" ", $finnishDate);
        if (count($dateParts) == 1) {
            throw new Exception("Illegal Finnish date '" . var_export($finnishDate, true). "'");
        }
        $finMonths = array('tammikuuta', 'helmikuuta', 'maaliskuuta', 'huhtikuuta', 'toukokuuta', 'kesäkuuta', 'heinäkuuta', 'elokuuta', 'syyskuuta', 'lokakuuta', 'marraskuuta', 'joulukuuta');
        $dateParts[1] = array_search($dateParts[1], $finMonths) +1;

        return DateTime::createFromFormat("j.n.Y H:i:s", $dateParts[0] . $dateParts[1] . "." . $dateParts[2] . " 00:00:00");
    }

} 
