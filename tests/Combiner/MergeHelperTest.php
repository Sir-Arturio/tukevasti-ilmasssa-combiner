<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use PHPUnit_Framework_TestCase,
    DateTime;

class MergeHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider mergeItemProvider
     */
    public function testMergeItems($item, $item2, $expected, $message) {
        $helper = new MergeHelper();
        $result = $helper->mergeItems($item, $item2);
        $this->assertEquals($expected, $result, $message);
    }

    public function mergeItemProvider() {
        return array(
          array(
            array(0 => null,  1 => null, '2006-01-23', 'Wiki merge', 'Test',),
            array('20060124_tukevasti_ilmassa.mp3', '2006-01-24'),
            array(
              '20060124_tukevasti_ilmassa.mp3',
              '2006-01-24',
              '2006-01-23',
              'Wiki merge',
              'Test',
            ),
            'Items with asymmetrical data with adjacent date are merged.'
          ),

          array(
            array('20060124_tukevasti_ilmassa.mp3', '2006-01-24'),
            array(0 => null,  1 => null, '2006-01-23', 'Wiki merge', 'Test',),
            array(
              '20060124_tukevasti_ilmassa.mp3',
              '2006-01-24',
              '2006-01-23',
              'Wiki merge',
              'Test',
            ),
            'Items with REVERSED asymmetrical data with adjacent date are merged.'
          ),

          array(
            array(0 => null,  1 => null, '2006-01-24', 'Wiki merge', 'Test',),
            array('20060124_tukevasti_ilmassa.mp3', '2006-01-24'),
            array(
              '20060124_tukevasti_ilmassa.mp3',
              '2006-01-24',
              '2006-01-24',
              'Wiki merge',
              'Test',
            ),
            'Items with asymmetrical data with SAME date are merged.'
          ),

          array(
            array(0 => null,  1 => null, '2006-01-01', 'Wiki merge', 'Test',),
            array('20060102_tukevasti_ilmassa.mp3', '2011-11-11'),
            false,
            'Items with asymmetrical data WITHOUT adjacent date are NOT merged.'
          ),
        );
    }

    /**
     * @dataProvider dateProvider
     */
    public function testAdjacentDate($date, $date2, $expected, $message) {
        $helper = new MergeHelper();
        $result = $helper->isAdjacentDate($date, $date2);
        $this->assertEquals($expected, $result, $message);
    }

    public function dateProvider() {
        return array(
          array(new DateTime('2014-01-01'), new DateTime('2014-01-02'), true, 'Adjacent dates are adjacent.'),
          array(new DateTime('2014-01-02'), new DateTime('2014-01-01'), true, 'Reversed adjacent dates are adjacent.'),
          array(new DateTime('2015-05-01'), new DateTime('2015-04-30'), true, 'Month spanning adjacent dates are adjacent.'),
          array(new DateTime('2015-01-01'), new DateTime('2015-01-01'), false, 'Same dates are not adjacent.'),
          array(new DateTime('2015-01-01'), new DateTime('2016-01-02'), false, 'Adjacent dates with different year are not adjacent.'),
          array(new DateTime('2015-01-01'), new DateTime('2015-02-02'), false, 'Adjacent dates with different month are not adjacent.'),
        );
    }
} 
