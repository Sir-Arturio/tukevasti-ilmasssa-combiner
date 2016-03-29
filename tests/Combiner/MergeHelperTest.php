<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use DateTime;
use PHPUnit_Framework_TestCase;
use TukevastiIlmassaDataCombiner\File\FileData;
use TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;

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
            new FileData('20060124_tukevasti_ilmassa.mp3', new DateTime('2006-01-24')),
            new WikiEpisodeInfo(new DateTime('2006-01-24'), 'Wiki merge', 'Test'),
            new MergedEpisode(
              new FileData('20060124_tukevasti_ilmassa.mp3', new DateTime('2006-01-24')),
              new WikiEpisodeInfo(new DateTime('2006-01-24'), 'Wiki merge', 'Test')
            ),
            'Items with the same date are merged.'
          ),

          array(
                new FileData('20060124_tukevasti_ilmassa.mp3', new DateTime('2006-01-24')),
                new WikiEpisodeInfo(new DateTime('2006-01-23'), 'Wiki merge', 'Test'),
                new MergedEpisode(
                    new FileData('20060124_tukevasti_ilmassa.mp3', new DateTime('2006-01-24')),
                    new WikiEpisodeInfo(new DateTime('2006-01-23'), 'Wiki merge', 'Test')
                ),
                'Items with the adjacent date are merged.'
            ),
            array(
                new FileData('20060129_tukevasti_ilmassa.mp3', new DateTime('2006-01-29')),
                new WikiEpisodeInfo(new DateTime('2006-01-23'), 'Wiki merge', 'Test'),
                false,
                'Items with nonadjacent date are not merged.'
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
