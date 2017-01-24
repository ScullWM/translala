<?php

namespace Translala\Infra\Application;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new \Translala\App\Command\TranslateCommand();
        $commands[] = new \Translala\App\Command\CommonCommand();
        $commands[] = new \Translala\App\Command\StatsCommand();
        $commands[] = new \Translala\App\Command\DeadCommand();

        return $commands;
    }
}