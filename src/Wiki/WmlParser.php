<?php


namespace TukevastiIlmassaDataCombiner\Wiki;

class WmlParser
{
  /**
   * @param $rawData
   * @return array
   */
  public function parse($rawData) {
    $content = str_replace(array("[[", "]]", "&nbsp;"), '', $rawData);
    $content = preg_replace('/!\|/m', '||', $content);
    $matches = preg_split('/\|-|{\|/', $content);

    foreach($matches as &$row) {
      $cells = explode("\n", $row);
      $cells = array_filter($cells, function ($cell) { return preg_match('/\|\|/', $cell); });
      $cells = preg_replace('/\|\|\s*/', '', $cells);
      if(isset($cells[1]) && count($cells) >= 3) {
        $cells[1] = prepare_date($cells[1]);
      }
      $row = $cells;
    }

    $matches = array_filter($matches);
    $matches = array_filter($matches, function($a) { return (is_object($a[1])) ? true : false; });
    $matches = array_filter($matches, function($a) { return ($a[2] == 'Uusinta edellisestä') ? false : true; });
    usort($matches, 'sort_by_date');
    $matches = array_map(function($a) { $a[1] = flatten_date($a[1]); return $a; }, $matches);
    print_r($matches);
    return $matches;
  }

  function sort_by_date($a, $b) {
    $a = flatten_date($a[1]);
    $b = flatten_date($b[1]);
    return strcmp($a, $b);
  }

  protected function flatten_date(DateTime $date) {
    return $date->format("Y-m-d");
  }

  /**
   * @param $finnish_date string
   * @return Date
   **/
  protected function prepare_date($finnishDate) {
    $dateParts = explode(" ", $finnishDate);
    if(count($dateParts) == 1) {
      return $finnishDate;
    }
    $finMonths = array('tammikuuta', 'helmikuuta', 'maaliskuuta', 'huhtikuuta', 'toukokuuta', 'kesäkuuta', 'heinäkuuta', 'elokuuta', 'syyskuuta', 'lokakuuta', 'marraskuuta', 'joulukuuta');
    $dateParts[1] = array_search($dateParts[1], $finMonths) +1;
    //echo $dateParts[0] . $dateParts[1] . "." . $dateParts[2] . "\n";

    return DateTime::createFromFormat("j.n.Y H:i:s", $dateParts[0] . $dateParts[1] . "." . $dateParts[2] . " 00:00:00");
  }

} 
