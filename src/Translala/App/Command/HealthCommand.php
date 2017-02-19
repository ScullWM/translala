<?php

namespace Translala\App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Translala\App\Command\AbstractCommand;
use Translala\App\Loader\ProjectLoader;
use Translala\Domain\Exception\HealthException;
use Translala\Domain\Model\CommandContext;
use Translala\Domain\Processor\HealthProcessor;
use Translala\Infra\Job\StatsJob;

class HealthCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('translala:status:health')
            ->setDescription('Check if translations are ok')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectLoader = new ProjectLoader($input->getOption('config'));
        $projectLoader->load(new CommandContext($input->getOption('domain'), $input->getOption('language')));

        $configFileData = $projectLoader->getConfig()->getData();

        if (!isset($configFileData['health'])) {
            throw new \Exception("Undefined data for health cmd");
        }

        $job = new StatsJob($projectLoader->getTranslationFiles(), $projectLoader->getConfig());
        $statsPerLocale = $job->process();

        $healthProcessor = new HealthProcessor($configFileData['health']);

        try {
            $healthProcessor->process($statsPerLocale);
        } catch (HealthException $e) {
            $output->writeln('Error: ' . $e->getMessage());
            exit(255);
        }

        exit(0);
    }
}