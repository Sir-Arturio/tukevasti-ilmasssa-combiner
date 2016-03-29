<?php

namespace TukevastiIlmassaDataCombiner\Media;

use PHPUnit_Framework_TestCase;
use TukevastiIlmassaDataCombiner\Combiner\MergedEpisode;
use TukevastiIlmassaDataCombiner\File\FileData;
use TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;

class Mp3WriterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider artistItemProvider
     */
    public function testGetArtistData($item, $expected, $message)
    {
        $writer = new Mp3Writer();
        $result = $writer->getArtistData($item);
        $this->assertEquals($expected, $result, $message);
    }

    public function artistItemProvider()
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
            'Items without presenter field return "Tukevasti Ilmassa" as an artist.',
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
            'Items with a presenter field will return "Tukevasti Ilmassa/<artists>" as an artist.',
          ),
        );
    }

    /**
     * @dataProvider titleItemProvider
     */
    public function testGetTitleData($item, $expected, $message)
    {
        $writer = new Mp3Writer();
        $result = $writer->getTitleData($item);
        $this->assertEquals($expected, $result, $message);
    }

    public function titleItemProvider()
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
            'Items without WikiData return "<fileDate> - Tukevasti Ilmassa" as a title.',
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
            'Items with WikiData and title field return "<wikiDate> - <title>" as a title.',
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
            'Items with WikiData but without a title field return "<wikiDate> - Tukevasti Ilmassa" as a title.',
          ),
        );
    }
}
