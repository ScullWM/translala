<?php

namespace Translala\App\Command;

use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    protected function configure()
    {
        parent::configure();
    }
}