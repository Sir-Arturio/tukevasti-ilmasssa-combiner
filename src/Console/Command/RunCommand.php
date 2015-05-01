<?php

namespace TukevastiIlmassaDataCombiner\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TukevastiIlmassaDataCombiner\Combiner\MergeHelper;
use TukevastiIlmassaDataCombiner\Combiner\WikiFileCombiner;
use TukevastiIlmassaDataCombiner\File\DirectoryListingParser;
use TukevastiIlmassaDataCombiner\Wiki\WmlParser;

class RunCommand extends Command
{
    protected function configure()
    {
        $this->setName("run");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rawWiki = file_get_contents('wiki2.txt');
        $rawFiles = scandir('.');

        $wikiParser = new WmlParser();
        $wikiData = $wikiParser->parse($rawWiki);

        $fileParser = new DirectoryListingParser();
        $files = $fileParser->parse($rawFiles);

        $combiner = new WikiFileCombiner();
        $result = $combiner->combine($wikiData, $files);
        $result = $combiner->merge($result, new MergeHelper());

        read_tags_and_combine_to_csv($result);
    }
}
