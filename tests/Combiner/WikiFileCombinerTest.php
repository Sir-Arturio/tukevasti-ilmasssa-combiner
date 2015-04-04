<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use PHPUnit_Framework_TestCase;

class WikiFileCombinerTest extends PHPUnit_Framework_TestCase
{
    public function testCombinerCombinesWikiAndFileDataToAFormattedResult()
    {
        $wiki = array(
          array(
            1 => "2012-12-17",
            "Kanada",
            "Ruotsi, jääkiekko, nelikenttä, ei-Amerikka",
            "J. Relander ja T. Nevanlinna",
          ),
          array
          (
            1 => "2013-01-07",
            "viikonpäivä|viikonpäivät",
            null,
            "T. Nevanlinna ja S. Hiidenheimo",
          ),
        );

        $files = array(
          array(
            '20010910_filosofit.mp3',
            '2001-09-10',
          ),
          array(
            '20121217_filosofit',
            '2012-12-17',
          ),
          array(
            '20141111_filosofit.mp3',
            '2014-11-11',
          ),

        );

        $expected = array(
          '2001-09-10' => array(
            '20010910_filosofit.mp3',
            '2001-09-10',
          ),
          '2012-12-17' => array(
            '20121217_filosofit',
            '2012-12-17',
            "2012-12-17",
            "Kanada",
            "Ruotsi, jääkiekko, nelikenttä, ei-Amerikka",
            "J. Relander ja T. Nevanlinna",
          ),
          '2013-01-07' => array(
            '0' => null,
            '1' => null,
            "2013-01-07",
            "viikonpäivä|viikonpäivät",
            null,
            "T. Nevanlinna ja S. Hiidenheimo",
          ),
          '2014-11-11' => array(
            '20141111_filosofit.mp3',
            '2014-11-11',
          ),
        );

        $combiner = new WikiFileCombiner();
        $result = $combiner->combine($wiki, $files);
        $this->assertEquals($expected, $result);
    }
} 
