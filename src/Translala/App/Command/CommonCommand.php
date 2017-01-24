<?php

namespace Translala\App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Translala\App\Command\AbstractCommand;
use Translala\App\Loader\ProjectLoader;
use Translala\Domain\Model\CommandContext;
use Translala\Infra\Job\CommonJob;

class CommonCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('translala:project:common')
            ->setDescription('Display common translations')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectLoader = new ProjectLoader($input->getOption('config'));
        $projectLoader->load(new CommandContext($input->getOption('domain'), $input->getOption('language')));

        $output->writeln('<info>√ Launching Common Command</info>');

        $job = new CommonJob($projectLoader->getTranslationFiles(), $projectLoader->getConfig());
        $stats = $job->process();
        $output->writeln('<info>√ Done</info>');

        $projectLoader->render('common.html.twig', ['listing' => $stats->getTranslationsListing()]);
        $output->writeln('<info>Report generated in common.html</info>');
    }
}