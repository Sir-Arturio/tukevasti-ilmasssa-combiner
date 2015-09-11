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

    public function writeInfoToFile($item)
    {
        $artist = "Tukevasti Ilmassa";

        $title = isset($item[3]) ? $item[3] : "Tukevasti Ilmassa";

        $id3v1 = new \Zend_Media_Id3v1($item[0]);
        $id3v1->setArtist("");
        $id3v1->setTitle("");
        $id3v1->write();

        $id3 = new \Zend_Media_Id3v2();

        $titleFrame = new \Zend_Media_Id3_Frame_Tit2();
        $titleFrame->setText($title);
        $id3->addFrame($titleFrame);

        $artistFrame = new \Zend_Media_Id3_Frame_Tpe1();
        $artistFrame->setText($artist);
        $id3->addFrame($artistFrame);

        $id3->write($item[0]);
    }
} 
