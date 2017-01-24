<?php

namespace Translala\Infra\Job;

use Symfony\Component\Process\Process;
use Translala\Domain\Model\ConfigFileInterface;
use Translala\Domain\Model\LocaleStats;
use Translala\Domain\Model\TranslationFileInterface;
use Translala\Domain\Model\TranslationInterface;

class DeadJob
{
    /**
     * @var array
     */
    private $translationsFiles;

    /**
     * @var ConfigFileInterface
     */
    private $configFile;

    /**
     * @var array
     */
    private $missingTranslations = [];

    /**
     * @param array $translationsFiles
     * @param ConfigFileInterface $configFile
     */
    public function __construct(array $translationsFiles, ConfigFileInterface $configFile)
    {
        $this->translationsFiles = $translationsFiles;
        $this->configFile        = $configFile;
    }

    public function process()
    {
        foreach ($this->translationsFiles as $translationFile) {
            array_map([$this, 'checkDeadTranslations'], $translationFile->getTranslations());
        }

        return $this->missingTranslations;
    }

    /**
     * @param  TranslationInterface $translation
     */
    protected function checkDeadTranslations(TranslationInterface $translation)
    {
        $process = new Process('grep -r "' . $translation->getKey() . '" ' . $this->configFile->getProjectPath());
        $process->run();

        if (!strstr($process->getOutput(), $translation->getKey())) {
            $this->missingTranslations[] = $translation->getKey();
        }
    }
}