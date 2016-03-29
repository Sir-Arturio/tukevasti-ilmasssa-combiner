<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use TukevastiIlmassaDataCombiner\File\FileData,
    TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;

class MergedEpisode
{
    /** @var FileData|null $fileData */
    protected $fileData;

    /** @var WikiEpisodeInfo|null $wikiEpisodeInfo */
    protected $wikiEpisodeInfo;

    /**
     * @param FileData|null $fileData
     * @param WikiEpisodeInfo|null $wikiEpisodeInfo
     */
    function __construct($fileData, $wikiEpisodeInfo)
    {
        $this->fileData = $fileData;
        $this->wikiEpisodeInfo = $wikiEpisodeInfo;
    }

  /**
   * @return FileData|null
   */
  public function getFileData() {
    return $this->fileData;
  }

  /**
   * @param FileData|null $fileData
   */
  public function setFileData($fileData) {
    $this->fileData = $fileData;
  }

  /**
   * @return WikiEpisodeInfo|null
   */
  public function getWikiEpisodeInfo() {
    return $this->wikiEpisodeInfo;
  }

  /**
   * @param WikiEpisodeInfo|null $wikiEpisodeInfo
   */
  public function setWikiEpisodeInfo($wikiEpisodeInfo) {
    $this->wikiEpisodeInfo = $wikiEpisodeInfo;
  }
} 
