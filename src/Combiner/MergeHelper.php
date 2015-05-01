<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use DateTime;

class MergeHelper
{
    public function mergeItems($item, $item2) {
        $items = array($item, $item2);

        // Check for asymmetric data and select data sources.
        $wikiCount = 0;
        $fileCount = 0;
        foreach($items as $subItem) {
            if($this->hasWikiData($subItem)) {
                $wikiCount++;
                $wiki = $subItem;
            }
            if($this->hasFileMetaData($subItem)) {
                $fileCount++;
                $file = $subItem;
            }

            // Item containing both data structures cannot be merged.
            if($this->hasWikiData($subItem) && $this->hasFileMetaData($subItem)) {
                return false;
            }
        }

        // Fail if data is not asymmetric.
        if($wikiCount != 1 || $fileCount != 1) {
            return false;
        }

        // Merge items.
        $wiki[0] = $file[0];
        $wiki[1] = $file[1];

        $date = new DateTime($wiki[1]);
        $date2 = new DateTime($wiki[2]);

        // Items without adjacent (or same) dates are not merged.
        if($date != $date2 && !$this->isAdjacentDate($date, $date2)) {
            return false;
        }

        return $wiki;
    }

    protected function hasFileMetaData($item) {
        return (isset($item[0]) && $item[0] !== null);
    }

    protected function hasWikiData($item) {
        return (isset($item[2]) && $item[2] !== null);
    }

    /**
     * Check if dates are adjacent.
     *
     * @param DateTime $date
     * @param DateTime $date2
     * @return bool
     */
    public function isAdjacentDate(DateTime $date, DateTime $date2) {
        $diff = $date->diff($date2);
        return $diff->days == 1;
    }
}
