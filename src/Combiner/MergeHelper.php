<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use DateTime;

class MergeHelper
{
    public function mergeItems($item, $item2) {
        $file = $this->hasFileMetaData($item) ? $item : $item2;
        $wiki = $this->hasWikiData($item) ? $item : $item2;

        $wiki[0] = $file[0];
        $wiki[1] = $file[1];

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
