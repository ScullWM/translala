<?php

namespace Translala\App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractCommand extends Command
{
    protected function configure()
    {
        $this
            ->addOption(
                '--config',
                '-c',
                InputOption::VALUE_OPTIONAL,
                "Config file directory",
                getcwd()
            )
            ->addOption(
                '--domain',
                '-d',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                "Desired domains",
                []
            )
            ->addOption(
                '--language',
                '-l',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                "Desired languages",
                []
            )
        ;
    }
}