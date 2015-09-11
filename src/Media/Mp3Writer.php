<?php

namespace TukevastiIlmassaDataCombiner\Media;

class Mp3Writer
{
    public function writeData($items)
    {
        foreach ($items as $item) {
            $this->writeInfoToFile($item);
        }
    }

    /**
     * Write item's information to the designated file.
     *
     * @param array $item
     * @throws \Zend_Media_Id3_Exception
     */
    public function writeInfoToFile(array $item)
    {
        $artist = $this->getArtistData($item);
        $title = $this->getTitleData($item);

        // Remove ID3v1 tags.
        $id3v1 = new \Zend_Media_Id3v1($item[0]);
        $id3v1->setArtist("");
        $id3v1->setTitle("");
        $id3v1->write();

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
     *
     * @param array $item
     * @return string
     */
    public function getArtistData(array $item)
    {
        $artist = array();
        $artist[] = "Tukevasti Ilmassa";
        if (isset($item[5])) {
            $artist[] = $item[5];
        }

        return implode('/', $artist);
    }

    /**
     * Format title data based on the item.
     *
     * @param array $item
     * @return string
     */
    public function getTitleData(array $item)
    {
        $title = array();
        $title[] = isset($item[2]) ? $item[2] : NULL;
        $title[] = isset($item[3]) ? $item[3] : "Tukevasti Ilmassa";
        return implode(' - ', $title);
    }
} 
