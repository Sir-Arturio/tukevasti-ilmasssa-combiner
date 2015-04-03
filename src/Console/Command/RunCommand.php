<?php

namespace TukevastiIlmassaDataCombiner\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TukevastiIlmassaDataCombiner\Wiki\WmlParser;

class RunCommand extends Command
{
  protected function configure() {
    $this->setName("run");
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $rawWiki  = file_get_contents('wiki2.txt');
    $rawFiles = scandir('.');

    $wikiParser = new WmlParser();
    $wikiData   = $wikiParser->parse($rawWiki);
    print_r($wikiData);
  }
}
