<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

class WikiFileCombiner
{
    /**
     * Combines the data from Wiki and Files together into a single element array.
     *
     * @param array $wikiData
     * @param array $files
     * @return array
     */
    public function combine(array $wikiData, array $files) {
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

    /**
     * @param array $source
     * @param MergeHelper $helper
     * @return array
     */
    public function merge(array $source, $helper) {
        $result = array();

        end($source);
        $lastKey = key($source);

        $previous = null;
        foreach($source as $key => $current) {
            // Do not try to merge if the previous item does not exist or is unmergeable.
            if($previous == null) {
                $previous = $current;

                // In case of the last element, the loop will not continue, so the current key has to be saved now.
                if($key == $lastKey) {
                    $result[] = $current;
                }
                continue;
            }

            $merged = $helper->mergeItems($previous, $current);
            // If merge succeeds, save merged result.
            // The current is already saved in the merged element, so it will not qualify as a next previous item.
            if($merged !== false) {
                $result[] = $merged;
                $previous = null;
                // Force continue as the last key check would cause the merged element to be saved if it's the last element.
                continue;
            }
            // Merge failed, so the previous has to saved without being merged and the current element qualifies as the next previous element.
            else {
                $result[] = $previous;
                $previous = $current;
            }

            // In case of the last element, the loop will not continue, so the current key has to be saved now.
            if($key == $lastKey) {
                $result[] = $current;
            }
        }

        return $result;
    }
} 
