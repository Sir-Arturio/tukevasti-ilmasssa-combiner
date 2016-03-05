<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use TukevastiIlmassaDataCombiner\File\FileData,
    TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;

class MergedEpisode
{
    /** @var FileData $fileData */
    protected $fileData;

    /** @var WikiEpisodeInfo $wikiEpisodeInfo */
    protected $wikiEpisodeInfo;

    /**
     * @param FileData $fileData
     * @param WikiEpisodeInfo $wikiEpisodeInfo
     */
    function __construct(FileData $fileData, WikiEpisodeInfo $wikiEpisodeInfo)
    {
        $this->fileData = $fileData;
        $this->wikiEpisodeInfo = $wikiEpisodeInfo;
    }

  /**
   * @return FileData
   */
  public function getFileData() {
    return $this->fileData;
  }

  /**
   * @param FileData $fileData
   */
  public function setFileData($fileData) {
    $this->fileData = $fileData;
  }

  /**
   * @return WikiEpisodeInfo
   */
  public function getWikiEpisodeInfo() {
    return $this->wikiEpisodeInfo;
  }

  /**
   * @param WikiEpisodeInfo $wikiEpisodeInfo
   */
  public function setWikiEpisodeInfo($wikiEpisodeInfo) {
    $this->wikiEpisodeInfo = $wikiEpisodeInfo;
  }
} 
