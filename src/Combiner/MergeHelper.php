<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use DateTime;

class MergeHelper
{
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
