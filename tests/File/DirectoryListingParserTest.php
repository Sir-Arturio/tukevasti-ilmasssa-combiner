<?php

namespace TukevastiIlmassaDataCombiner\File;

use PHPUnit_Framework_TestCase;
use DateTime;

class DirectoryListingParserTest extends PHPUnit_Framework_TestCase
{
    public function testParserReturnsFormattedResultFromRawFileData()
    {
        $source = array(
          '.',
          '..',
          '20010319_tukevasti_ilmassa.mp3',
          'test.txt',
          '20070910_tukevasti.mp3',
          '.git',
          'text.txt',
          '20080303_tukevasti.mp3',
          'tukevasti_ilmassa_without_a_date.mp3',
        );

        $expected = array(
          new FileData(
            '20010319_tukevasti_ilmassa.mp3',
            new DateTime('2001-03-19')
          ),
          new FileData(
            '20070910_tukevasti.mp3',
            new DateTime('2007-09-10')
          ),
          new FileData(
            '20080303_tukevasti.mp3',
            new DateTime('2008-03-03')
          ),
          new FileData(
            'tukevasti_ilmassa_without_a_date.mp3',
            null
          ),
        );

        $parser = new DirectoryListingParser();
        $result = $parser->parse($source);

        $this->assertEquals(
          $expected,
          $result,
          'DirectoryListingParser parses the data to a standard form.'
        );
    }
} 
