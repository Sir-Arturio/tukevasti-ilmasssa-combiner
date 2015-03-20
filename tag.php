<?php

$files = scandir('.');
$files = array_filter($files, function ($file) { return preg_match('|.mp3$|', $file); });

function get_date_from_filename($filename) {
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

function process_file($filename) {
  return array($filename, get_date_from_filename($filename));
}

$file_data = array_map("process_file", $files);
//$file_dates = array_filter($file_dates, function($val) { return ($val[1] == '00-00-0000');});
// print_r($file_dates);

include "wiki.php";
//print_r(array_pop($matches));

//echo "FILES: " . count($file_dates) ." WIKI: " . count($matches) ." \n";

$file_dates = array_map(function ($a) { return $a[1]; }, $file_data);
//print_r($file_dates);

$non_matching_matches = array_filter($matches, function ($a) use($file_dates) { return !in_array($a[1], $file_dates); });
print_r($non_matching_matches);
echo "NON MATCHING COUNT: " . count($non_matching_matches) ." \n";

// COMBINE DATA
$combined = array();
foreach($file_data as $item) {
  $combined[$item[1]] = $item;
}
foreach($matches as $item) {
  $combined[$item[1]] = (array_key_exists($item[1], $combined)) ? array_merge($combined[$item[1]], $item) : array_merge(array(null, null), $item);
}
ksort($combined);

$fp = fopen('ti.csv', 'w');
foreach($combined as $line) {
  fputcsv($fp, $line);
}
fclose($fp);

// Analyze missing files
foreach($combined as $key => $item) {
  if(empty($item[0])) {
    echo "FILE " . $item[2] . " MISSING. ";
    echo "PREV FILE: " . prev($combined)[0] ." ";
    next($combined);
    echo "NEXT FILE: " . next($combined)[0] ." ";
    echo "\n";
  }
}
array_walk($combined, function($a) { if(empty($a[0])) echo "FILE " . $a[2] . " MISSING. PREV FILE "; });





//$combined = array_map(function ($a, $b) { $b = is_array($b) ? $b : array(); return array_merge($a, $b); }, $file_dates, $matches);
//print_r($combined);

//$wiki_dates = array_map(function ($entry) { return is_object($entry[1]) ? $entry[1]->format("Y-m-d") : '0000-00-00'; }, $matches);
//print_r($wiki_dates);
//print_r($wiki_dates);

function date_differ($a, $b) {
  $aParts = explode("-", $a);
  $aPartsBig = $aParts;
  $aParts[2] = str_pad($aParts[2]-1, 2, "0", STR_PAD_LEFT);
  $aPartsBig[2] = str_pad($aPartsBig[2]+1, 2, "0", STR_PAD_LEFT);
  $aArr = array($a, implode("-", $aParts), implode("-", $aPartsBig));
  
  if(in_array($b, $aArr)) {
    return 0;
  }
  
  if($a > $b) {
    return 1;
  }
  else return -1;
}

//print_r(array_udiff($wiki_dates, $file_dates, "date_differ"));
