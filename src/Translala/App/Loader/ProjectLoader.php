<?php

namespace Translala\App\Loader;

use Translala\Domain\Model\CommandContext;
use Translala\Domain\Model\ConfigFile;

class ProjectLoader
{
    /**
     * @var ConfigFileInterface
     */
    private $configFile;

    /**
     * @param string $filepath
     */
    public function __construct($filepath)
    {
        $this->configFile = new ConfigFile($filepath);
    }

    /**
     * @param  CommandContext $context
     */
    public function load(CommandContext $context)
    {
        $translationPaths = $this->configFile->getTranslationPaths();

        $filespath = [];
        foreach ($translationPaths as $path) {
            $filespath[] = $this->loadPath($context);
        }


    }


    /**
     * @param  CommandContext $context
     * @return array
     */
    public function loadPath(CommandContext $context)
    {

    }
}