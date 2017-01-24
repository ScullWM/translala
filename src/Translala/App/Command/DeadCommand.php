<?php

namespace Translala\App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Translala\App\Command\AbstractCommand;
use Translala\App\Loader\ProjectLoader;
use Translala\Domain\Model\CommandContext;
use Translala\Infra\Job\DeadJob;

class DeadCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('translala:project:dead')
            ->setDescription('I see dead translations')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectLoader = new ProjectLoader($input->getOption('config'));
        $projectLoader->load(new CommandContext($input->getOption('domain'), $input->getOption('language')));

        $output->writeln('<info>√ Launching Dead Command</info>');

        $job = new DeadJob($projectLoader->getTranslationFiles(), $projectLoader->getConfig());
        $deads = $job->process();
        $output->writeln('<info>√ Done</info>');

        $projectLoader->render('dead.html.twig', ['deads' => $deads]);
        $output->writeln('<info>Report generated in dead.html</info>');
    }
}