<?php

namespace TukevastiIlmassaDataCombiner\Media;

use PHPUnit_Framework_TestCase;

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
            array(
              '20060124_tukevasti_ilmassa.mp3',
              '2006-01-24',
              '2006-01-23',
              'Title',
              'Test',
            ),
            'Tukevasti Ilmassa',
            'Items without an artist field return "Tukevasti Ilmassa" as an artist.',
          ),
          array(
            array(
              '20060124_tukevasti_ilmassa.mp3',
              '2006-01-24',
              '2006-01-23',
              'Title',
              'Test',
              'J. Relander ja T. Nevanlinna',
            ),
            'Tukevasti Ilmassa/J. Relander ja T. Nevanlinna',
            'Items with an artist field will return "Tukevasti Ilmassa/<artists>" as an artist.',
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
            array(
              '20060124_tukevasti_ilmassa.mp3',
              '2006-01-24',
              '2006-01-23',
            ),
            '2006-01-23 - Tukevasti Ilmassa',
            'Items without a title field return "<wikiDate> - Tukevasti Ilmassa" as a title.',
          ),
          array(
            array(
              '20060124_tukevasti_ilmassa.mp3',
              '2006-01-24',
              '2006-01-23',
              'Title',
              'Test',
              'J. Relander ja T. Nevanlinna',
            ),
            '2006-01-23 - Title',
            'Items with a title field return "<wikiDate> - <title>" as a title.',
          ),
        );
    }
}
