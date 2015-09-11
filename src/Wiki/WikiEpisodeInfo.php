<?php

namespace TukevastiIlmassaDataCombiner\Wiki;

use DateTime;

class WikiEpisodeInfo
{
    /** @var DateTime $date */
    protected $date;

    /** @var string $title */
    protected $title;

    /** @var string|null $keywords */
    protected $keywords;

    /** @var string|null $presenters */
    protected $presenters;

    /**
     * @param DateTime $date
     * @param string $title
     * @param string|null $keywords
     * @param string|null $presenters
     */
    function __construct(DateTime $date, $title, $keywords = null, $presenters = null)
    {
        $this->date = $date;
        $this->title = $title;
        $this->keywords = $keywords;
        $this->presenters = $presenters;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param null|string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return null|string
     */
    public function getPresenters()
    {
        return $this->presenters;
    }

    /**
     * @param null|string $presenters
     */
    public function setPresenters($presenters)
    {
        $this->presenters = $presenters;
    }
} 
