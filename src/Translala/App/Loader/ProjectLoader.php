<?php

namespace Translala\App\Loader;

use Translala\Domain\Model\CommandContext;
use Translala\Domain\Model\ConfigFile;
use Translala\Domain\Model\TranslationFile;
use Translala\Infra\Parser\FileParser;

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
            foreach (glob($path . '*.' . $this->configFile->getMasterLocale() . '.yml') as $translationFile) {

                $translationFileModel = new TranslationFile($translationFile, new FileParser($translationFile));
                $translationFileModel->parse();
                $this->translationsFiles[] = $translationFileModel;
            }
        }
    }

    /**
     * @return array
     */
    public function getTranslationFiles()
    {
        return $this->translationsFiles;
    }

    /**
     * @return ConfigFileInterface
     */
    public function getConfig()
    {
        return $this->configFile;
    }
}