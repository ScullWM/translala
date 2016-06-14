<?php

namespace Translala\App\Loader;

use Translala\Domain\Model\CommandContext;
use Translala\Domain\Model\ConfigFile;

class ProjectLoader implements LoaderInterface
{
    /**
     * @var ConfigFileInterface
     */
    private $configFile;

    /**
     * @var array
     */
    private $translationsFiles = [];

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

        foreach ($translationPaths as $path) {
            $this->loadPath($context, $path);
        }
    }

    /**
     * @param  CommandContext $context
     * @param  string $path
     * @return array
     */
    public function loadPath(CommandContext $context, $path)
    {
        $this->translationsFiles[] = new TranslationFile($path);
    }

    /**
     * @return array
     */
    public function getTranslationFiles()
    {
        return $this->translationsFiles;
    }
}