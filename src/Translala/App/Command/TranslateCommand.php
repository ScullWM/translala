<?php

namespace Translala\App\Command;

use Translala\App\Command\AbstractCommand;
use Translala\App\Loader\ProjectLoader;

class TranslateCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('translala:project:translate')
            ->setDescription('Guess missing translations')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectLoader = new ProjectLoader($input->getOption('path'));
        $projectLoader->load(new CommandContext($input->getOption('domain'), $input->getOption('locale')));
    }
}