<?php

namespace Translala\App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Translala\App\Command\AbstractCommand;
use Translala\App\Loader\ProjectLoader;
use Translala\Domain\Model\CommandContext;
use Translala\Infra\Job\StatsJob;

class StatsCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('translala:project:stats')
            ->setDescription('Display stats translations')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectLoader = new ProjectLoader($input->getOption('config'));
        $projectLoader->load(new CommandContext($input->getOption('domain'), $input->getOption('language')));

        $output->writeln('<info>√ Launching Stats Command</info>');

        $job = new StatsJob($projectLoader->getTranslationFiles(), $projectLoader->getConfig());
        $statsLocale = $job->process();
        $output->writeln('<info>√ Done</info>');

        $projectLoader->render('stats.html.twig', ['locales' => $statsLocale]);
        $output->writeln('<info>Report generated in stats.html</info>');
    }
}