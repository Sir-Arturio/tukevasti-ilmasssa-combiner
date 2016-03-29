<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;
use TukevastiIlmassaDataCombiner\File\FileData;

class WikiFileCombiner
{
    /**
     * Combines the data from Wiki and files together into a MergedEpisode element array.
     *
     * @param WikiEpisodeInfo[] $wikiEpisodes
     * @param FileData[] $files
     * @param MergeHelper $helper
     * @return MergedEpisode[]
     */
    public function combine(array $wikiEpisodes, array $files, MergeHelper $helper) {
        $mergedList = array();
        $failedWikiEpisodes = array();

        foreach($wikiEpisodes as $wiki) {
            foreach($files as $fileKey => $file) {
                $mergedEpisode = $helper->mergeItems($file, $wiki);
                if($mergedEpisode) {
                    $date = $wiki->getDate()->format("Y-m-d");
                    $mergedList[$date] = $mergedEpisode;
                    break;
                }
            }

            // Remove merged FileData from the list. (In the end, the reminder of the files will be the unmergeable set of FileData).
            if($mergedEpisode) {
                unset($files[$fileKey]);
            }
            // Add failed WikiEpisode to the fail list for later processing.
            else {
                $failedWikiEpisodes[] = $wiki;
            }
        }

        // Add failed WikiEpisodes to the merged list as partials.
        foreach($failedWikiEpisodes as $wiki) {
            $partial = new MergedEpisode(null, $wiki);
            $date = $wiki->getDate()->format("Y-m-d");
            $mergedList[$date] = $partial;
        }

        // Add failed FileData to the merged list as partials.
        foreach($files as $file) {
            $partial = new MergedEpisode($file, null);
            $date = $file->getDate()->format("Y-m-d");
            $mergedList[$date] = $partial;
        }

        return $mergedList;
    }
} 
