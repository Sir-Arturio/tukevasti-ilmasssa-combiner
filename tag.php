<?php

function read_tags_and_combine_to_csv($combined) {
    // SHOW NON-MATCHING ELEMENTS
    /*$file_dates = array_map(function ($a) { return $a[1]; }, $files);
    $non_matching_matches = array_filter($wikiData, function ($a) use($file_dates) { return !in_array($a[1], $file_dates); });
    print_r($non_matching_matches);
    echo "NON MATCHING COUNT: " . count($non_matching_matches) ." \n";*/

  $fp = fopen('ti.csv', 'w');
  foreach($combined as $line) {
    fputcsv($fp, $line);
  }
  fclose($fp);

  // Analyze missing files
  /*foreach($combined as $key => $item) {
    if(empty($item[0])) {
      echo "FILE " . $item[2] . " MISSING. ";
      echo "PREV FILE: " . prev($combined)[0] ." ";
      next($combined);
      echo "NEXT FILE: " . next($combined)[0] ." ";
      echo "\n";
    }
  }*/
  //array_walk($combined, function($a) { if(empty($a[0])) echo "FILE " . $a[2] . " MISSING. PREV FILE "; });
}

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
