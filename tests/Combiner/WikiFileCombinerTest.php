<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;

class WikiFileCombinerTest extends ProphecyTestCase
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

    /**
     * @dataProvider elementArrayProvider
     */
    public function testMergeLoopsThroughTheGivenElementArrayAndMergesMergeableItems($items, $expected, $message) {
        $combiner = new WikiFileCombiner();

        $mergeHelper = $this->prophesize('TukevastiIlmassaDataCombiner\Combiner\MergeHelper');
        $mergeHelper->mergeItems(Argument::any(), Argument::any())->will(function($args) {
              $item = $args[0];
              $item2 = $args[1];
              if(!isset($item['mergeable']) || !isset($item2['mergeable'])) {
                  return false;
              }
              return array($item[0], $item2[0]);
          });

        $result = $combiner->merge($items, $mergeHelper->reveal());
        $this->assertEquals($expected, $result, $message);
    }

    public function mockMerge() {
        print_r(get_defined_vars());
        if(!isset($item['mergeable']) || !isset($item2['mergeable'])) {
            return false;
        }

        return array($item[0], $item2[0]);
    }

    public function elementArrayProvider() {
        return array(
            array(
              array(
                array('a'),
                array('b'),
                array('c', 'mergeable' => true),
                array('d', 'mergeable' => true),
                array('e'),
                array('f'),
              ),
              array(
                array('a'),
                array('b'),
                array('c', 'd'),
                array('e'),
                array('f'),
              ),
              'Mergeable items in the middle of the list are merged.',
            ),

          array(
            array(
              array('a', 'mergeable' => true),
              array('b', 'mergeable' => true),
              array('c'),
              array('d'),
            ),
            array(
              array('a', 'b'),
              array('c'),
              array('d'),
            ),
            'Mergeable items at the beginning of the list are merged.',
          ),

          array(
            array(
              array('a'),
              array('b'),
              array('c', 'mergeable' => true),
              array('d', 'mergeable' => true),
            ),
            array(
              array('a'),
              array('b'),
              array('c', 'd'),
            ),
            'Mergeable items at the end of the list are merged.',
          ),


          array(
            array(
              array('a'),
              array('b'),
              array('c', 'mergeable' => true),
              array('d', 'mergeable' => true),
              array('e'),
            ),
            array(
              array('a'),
              array('b'),
              array('c', 'd'),
              array('e'),
            ),
            'Mergeable items at the end -1 of the list are merged.',
          ),

          array(
            array(
              array('a'),
              array('b', 'mergeable' => true),
              array('c', 'mergeable' => true),
              array('d'),
              array('e'),
            ),
            array(
              array('a'),
              array('b', 'c'),
              array('d'),
              array('e'),
            ),
            'Mergeable items at the beginning +1 of the list are merged.',
          ),

          array(
            array(
              array('a'),
              array('b'),
              array('c'),
            ),
            array(
              array('a'),
              array('b'),
              array('c'),
            ),
            'Unmergeable items stay tha same.',
          ),

          array(
            array(),
            array(),
            'An empty list is processed without errors.',
          ),

          array(
            array(
              array('a', 'mergeable' => true),
              array('b', 'mergeable' => true),
              array('c', 'mergeable' => true),
              array('d', 'mergeable' => true),
              array('e', 'mergeable' => true),
              array('f', 'mergeable' => true),
            ),
            array(
              array('a', 'b'),
              array('c', 'd'),
              array('e', 'f'),
            ),
            'A list full of mergeable items merges properly.',
          ),
        );
    }
} 
