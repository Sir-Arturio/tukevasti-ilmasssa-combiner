<?php

namespace TukevastiIlmassaDataCombiner\File;

class FileData
{
    /** @var string $filename */
    protected $fileName;

    /** @var \DateTime|null $date */
    protected $date;

    /**
     * @param $fileName
     * @param \DateTime|null $date
     */
    public function __construct($fileName, \DateTime $date = null)
    {
        $this->fileName = $fileName;
        $this->date = $date;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setDate(\DateTime $date = null)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
} 
