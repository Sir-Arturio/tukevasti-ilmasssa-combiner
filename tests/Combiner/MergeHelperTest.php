<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use PHPUnit_Framework_TestCase,
    DateTime;

class MergeHelperTest extends PHPUnit_Framework_TestCase
{
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
