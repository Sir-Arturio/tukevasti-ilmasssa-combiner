<?php

namespace TukevastiIlmassaDataCombiner\Media;

use PHPUnit_Framework_TestCase;
use TukevastiIlmassaDataCombiner\Combiner\MergedEpisode;
use TukevastiIlmassaDataCombiner\File\FileData;
use TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;

class Mp3WriterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider artistEpisodeProvider
     */
    public function testGetArtistData($episode, $expected, $message)
    {
        $writer = new Mp3Writer();
        $result = $writer->getArtistData($episode);
        $this->assertEquals($expected, $result, $message);
    }

    public function artistEpisodeProvider()
    {
        return array(
          array(
            new MergedEpisode(
              new FileData(
                '20060124_tukevasti_ilmassa.mp3', new \DateTime('2006-01-24')
              ),
              new WikiEpisodeInfo(
                new \DateTime('2006-01-23'),
                'Title',
                'Test'
              )
            ),
            'Tukevasti Ilmassa',
            'Episodes without presenter field return "Tukevasti Ilmassa" as an artist.',
          ),
          array(
            new MergedEpisode(
              new FileData(
                '20060124_tukevasti_ilmassa.mp3', new \DateTime('2006-01-24')
              ),
              new WikiEpisodeInfo(
                new \DateTime('2006-01-23'),
                'Title',
                'Test',
                'J. Relander ja T. Nevanlinna'
              )
            ),
            'Tukevasti Ilmassa/J. Relander ja T. Nevanlinna',
            'Episodes with a presenter field will return "Tukevasti Ilmassa/<artists>" as an artist.',
          ),
        );
    }

    /**
     * @dataProvider titleEpisodeProvider
     */
    public function testGetTitleData($episode, $expected, $message)
    {
        $writer = new Mp3Writer();
        $result = $writer->getTitleData($episode);
        $this->assertEquals($expected, $result, $message);
    }

    public function titleEpisodeProvider()
    {
        return array(
          array(
            new MergedEpisode(
              new FileData(
                '20060124_tukevasti_ilmassa.mp3', new \DateTime('2006-01-24')
              ),
              null
            ),
            '2006-01-24 - Tukevasti Ilmassa',
            'Episodes without WikiData return "<fileDate> - Tukevasti Ilmassa" as a title.',
          ),
          array(
            new MergedEpisode(
              new FileData(
                '20060124_tukevasti_ilmassa.mp3', new \DateTime('2006-01-24')
              ),
              new WikiEpisodeInfo(
                new \DateTime('2006-01-23'),
                'Title',
                'Test',
                'J. Relander ja T. Nevanlinna'
              )
            ),
            '2006-01-23 - Title',
            'Episodes with WikiData and title field return "<wikiDate> - <title>" as a title.',
          ),
          array(
            new MergedEpisode(
              new FileData(
                '20060124_tukevasti_ilmassa.mp3', new \DateTime('2006-01-24')
              ),
              new WikiEpisodeInfo(
                new \DateTime('2006-01-23'),
                null,
                'Test',
                'J. Relander ja T. Nevanlinna'
              )
            ),
            '2006-01-23 - Tukevasti Ilmassa',
            'Episodes with WikiData but without a title field return "<wikiDate> - Tukevasti Ilmassa" as a title.',
          ),
        );
    }
}
