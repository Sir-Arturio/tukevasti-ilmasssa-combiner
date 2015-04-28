<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use DateTime;

class MergeHelper
{
    public function isAdjacentDate(DateTime $date, DateTime $date2) {
        $diff = $date->diff($date2);
        return $diff->days == 1;
    }
}
