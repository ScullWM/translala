<?php

namespace Translala\App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Translala\App\Command\AbstractCommand;
use Translala\App\Loader\ProjectLoader;
use Translala\Domain\Model\CommandContext;
use Translala\Infra\Job\TranslateJob;

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
        $projectLoader = new ProjectLoader($input->getOption('config'));
        $projectLoader->load(new CommandContext($input->getOption('domain'), $input->getOption('language')));

        $job = new TranslateJob($projectLoader->getTranslationFiles(), $projectLoader->getConfig());
        $job->process();
    }
}