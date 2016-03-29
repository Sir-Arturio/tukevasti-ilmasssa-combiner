<?php

namespace TukevastiIlmassaDataCombiner\Combiner;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;
use TukevastiIlmassaDataCombiner\File\FileData;
use TukevastiIlmassaDataCombiner\Wiki\WikiEpisodeInfo;

class WikiFileCombinerTest extends ProphecyTestCase
{
    /**
     * @dataProvider combinerTestProvider
     */
    public function testCombinerCombinesWikiAndFileData($wikiList, $fileList, $expected, $message) {
        $combiner = new WikiFileCombiner();
        $result = $combiner->combine($wikiList, $fileList, new MergeHelper());
        $this->assertEquals($expected, $result, $message);
    }

    public function combinerTestProvider() {
        return array(
          array(
            array(
                new WikiEpisodeInfo(new \DateTime("2012-12-17"), "Kanada", "Ruotsi, jääkiekko, nelikenttä, ei-Amerikka", "J. Relander ja T. Nevanlinna"),
            ),
            array(
                new FileData('20121218_filosofit', new \DateTime('2012-12-18')),
            ),
            array(
                "2012-12-17" => new MergedEpisode(new FileData('20121218_filosofit', new \DateTime('2012-12-18')), new WikiEpisodeInfo(new \DateTime("2012-12-17"), "Kanada", "Ruotsi, jääkiekko, nelikenttä, ei-Amerikka", "J. Relander ja T. Nevanlinna")),
            ),
            'A singular lists with adjacent elements is combined properly.',
          ),

          array(
            array(
              new WikiEpisodeInfo(new \DateTime("2012-12-17"), "Match", "", ""),
              new WikiEpisodeInfo(new \DateTime("2012-12-30"), "Does not match", "", ""),
              new WikiEpisodeInfo(new \DateTime("2013-01-15"), "Match 2", "", ""),
            ),
            array(
              new FileData('20121217_filosofit', new \DateTime('2012-12-17')),
              new FileData('20130115_filosofit', new \DateTime('2013-01-15')),
            ),
            array(
              "2012-12-17" => new MergedEpisode(new FileData('20121217_filosofit', new \DateTime('2012-12-17')), new WikiEpisodeInfo(new \DateTime("2012-12-17"), "Match", "", "")),
              "2012-12-30" => new MergedEpisode(null, new WikiEpisodeInfo(new \DateTime("2012-12-30"), "Does not match", "", "")),
              "2013-01-15" => new MergedEpisode(new FileData('20130115_filosofit', new \DateTime('2013-01-15')), new WikiEpisodeInfo(new \DateTime("2013-01-15"), "Match 2", "", "")),
            ),
            'An unmergeable WikiEpisode is preserved to the final list.',
          ),

          array(
            array(
              new WikiEpisodeInfo(new \DateTime("2012-12-17"), "Match", "", ""),
              new WikiEpisodeInfo(new \DateTime("2013-01-15"), "Match 2", "", ""),
            ),
            array(
              new FileData('20121217_filosofit', new \DateTime('2012-12-17')),
              new FileData('20121230_filosofit', new \DateTime('2012-12-30')),
              new FileData('20130115_filosofit', new \DateTime('2013-01-15')),
            ),
            array(
              "2012-12-17" => new MergedEpisode(new FileData('20121217_filosofit', new \DateTime('2012-12-17')), new WikiEpisodeInfo(new \DateTime("2012-12-17"), "Match", "", "")),
              "2012-12-30" => new MergedEpisode(new FileData('20121230_filosofit', new \DateTime('2012-12-30')), null),
              "2013-01-15" => new MergedEpisode(new FileData('20130115_filosofit', new \DateTime('2013-01-15')), new WikiEpisodeInfo(new \DateTime("2013-01-15"), "Match 2", "", "")),
            ),
            'An unmergeable FileData is preserved to the final list.',
          ),

          array(
              array(),
              array(),
              array(),
              'An empty list is combined properly.',
            ),
        );
    }
} 
