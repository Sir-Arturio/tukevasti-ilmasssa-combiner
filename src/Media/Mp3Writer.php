<?php

namespace TukevastiIlmassaDataCombiner\Media;

use TukevastiIlmassaDataCombiner\Combiner\MergedEpisode;

class Mp3Writer
{
    /**
     * Write merged episode data back to MP3 files.
     *
     * @param MergedEpisode[] $items
     */
    public function writeData(array $items)
    {
        foreach ($items as $item) {
            $this->writeInfoToFile($item);
        }
    }

    /**
     * Write item's information to the designated file.
     *
     * @param MergedEpisode $item
     * @throws \Zend_Media_Id3_Exception
     */
    public function writeInfoToFile(MergedEpisode $item)
    {
        if(!isset($item[0])) {
            return FALSE;
        }
        $artist = $this->getArtistData($item);
        $title = $this->getTitleData($item);

        // Remove ID3v1 tags.
        try {
            $id3v1 = new \Zend_Media_Id3v1($item[0]);
            $id3v1->setArtist("");
            $id3v1->setTitle("");
            $id3v1->write();
        }
        catch(\Exception $e) {}

        // Add ID3v2 tags.
        $id3 = new \Zend_Media_Id3v2();

        $titleFrame = new \Zend_Media_Id3_Frame_Tit2();
        $titleFrame->setText($title);
        $id3->addFrame($titleFrame);

        $artistFrame = new \Zend_Media_Id3_Frame_Tpe1();
        $artistFrame->setText($artist);
        $id3->addFrame($artistFrame);

        $id3->write($item[0]);
    }

    /**
     * Format artist data based on the item.
     * Returns either Tukevasti Ilmassa or Tukevasti Ilmassa/<presenters> (if presenters available).
     *
     * @param MergedEpisode $item
     * @return string
     */
    public function getArtistData(MergedEpisode $item)
    {
        $artist = array();
        $artist[] = "Tukevasti Ilmassa";
        $presenters = $item->getWikiEpisodeInfo()->getPresenters();
        if ($presenters) {
            $artist[] = $presenters;
        }

        return implode('/', $artist);
    }

    /**
     * Format title data based on the item.
     * Returns <wikiDate> - <Title> if WikiEpisodeInfo available.
     * Returns <wikiDate> - Tukevasti Ilmassa if WikiEpisodeInfo available but title not present.
     * Returns <fileDate> - Tukevasti Ilmassa if WikiEpisodeInfo NOT available.
     *
     * @param MergedEpisode $item
     * @return string
     */
    public function getTitleData(MergedEpisode $item)
    {
        $title = array();
        $file = $item->getFileData();
        $wiki = $item->getWikiEpisodeInfo();
        $title[] = $wiki ? $wiki->getDate()->format("Y-m-d") : $file->getDate()->format("Y-m-d");
        $title[] = $wiki && $wiki->getTitle() ? $wiki->getTitle() : "Tukevasti Ilmassa";
        return implode(' - ', $title);
    }
} 
