<?php

namespace TukevastiIlmassaDataCombiner\File;

use PHPUnit_Framework_TestCase;

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
        );

        $expected = array(
          array(
            '20010319_tukevasti_ilmassa.mp3',
            '2001-03-19',
          ),
          array(
            '20070910_tukevasti.mp3',
            '2007-09-10',
          ),
          array(
            '20080303_tukevasti.mp3',
            '2008-03-03',
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
