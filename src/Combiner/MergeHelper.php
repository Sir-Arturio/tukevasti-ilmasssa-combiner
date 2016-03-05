<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use DateTime;
use TukevastiIlmassaDataCombiner\File\FileData;
use TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;

class MergeHelper
{
    /**
     * Merge items if dates are adjacent.
     *
     * @param FileData $file
     * @param WikiEpisodeInfo $wiki
     * @return bool|MergedEpisode
     */
    public function mergeItems(FileData $file, WikiEpisodeInfo $wiki)
    {
        if($this->isAdjacentDate($file->getDate(), $wiki->getDate())) {
            return new MergedEpisode($file, $wiki);
        }
        return false;
    }

    /**
     * Check if dates are adjacent.
     *
     * @param DateTime $date
     * @param DateTime $date2
     * @return bool
     */
    public function isAdjacentDate(DateTime $date, DateTime $date2)
    {
        $diff = $date->diff($date2);
        return $diff->days == 1;
    }
}
