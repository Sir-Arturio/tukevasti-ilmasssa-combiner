<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

class WikiFileCombiner
{
    public function combine($wikiData, $files) {
        $combined = array();
        foreach ($files as $item) {
            $combined[$item[1]] = $item;
        }
        foreach ($wikiData as $item) {
            $combined[$item[1]] = (array_key_exists($item[1], $combined)) ? array_merge($combined[$item[1]], $item) : array_merge(array(null, null), $item);
        }
        ksort($combined);
        return $combined;
    }
} 
