<?php

namespace TukevastiIlmassaDataCombiner\Wiki;

use PHPUnit_Framework_TestCase;

class WmlParserTest extends PHPUnit_Framework_TestCase
{
    public function testParserReturnsFormattedResultFromRawWikiOutput()
    {
        $data = '
=== Kevät 2001 ===
{| class="wikitable"
!| Päivämäärä
!| Teema
!| Avainsanat
|-
!| [[5. maaliskuuta]] [[2001]]
|| Ensimmäinen lähetys
|| &nbsp;
|-
!| [[19. maaliskuuta]] [[2001]]
|| [[Hyvinvointivaltio]]
|| &nbsp;
|}

=== Syksy 2006 ===
{| class="wikitable"
!| Päivämäärä
!| Teema
!| Avainsanat
|-
!| [[4. joulukuuta]] [[2006]]
|| [[Kalenteri]]
|| [[perisynti]], bilekalenteri
|-
!| [[11. joulukuuta]] [[2006]]
|| 2056
|| &nbsp;
|}

=== Kevät 2007 ===
{|
!| [[11. kesäkuuta]] [[2007]]
|| Muuttaminen
|| Muuttopitsa, tavara
|| J.Relander ja T.Nevanlinna
|}
';
        $expected = array(
          array(
            1 => '2001-03-05',
            'Ensimmäinen lähetys',
            '',
          ),
          array(
            1 => '2001-03-19',
            'Hyvinvointivaltio',
            '',
          ),
          array(
            1 => '2006-12-04',
            'Kalenteri',
            'perisynti, bilekalenteri',
          ),
          array(
            1 => '2006-12-11',
            '2056',
            '',
          ),
          array(
            1 => '2007-06-11',
            'Muuttaminen',
            'Muuttopitsa, tavara',
            'J.Relander ja T.Nevanlinna'
          ),
        );

        $parser = new WmlParser();
        $result = $parser->parse($data);
        $this->assertEquals(
          $expected,
          $result,
          'WmlParser parses the raw data to a standard form.'
        );
    }
}
