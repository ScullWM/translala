<?php

namespace Translala\Infra\Job;

use Translala\Domain\Model\ConfigFileInterface;
use Translala\Domain\Model\LocaleStats;
use Translala\Domain\Model\TranslationFileInterface;
use Translation\Translator\Translator;

class StatsJob
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
     * @param array $translationsFiles
     */
    public function __construct(array $translationsFiles, ConfigFileInterface $configFile)
    {
        $this->translationsFiles = $translationsFiles;
        $this->configFile        = $configFile;
    }

    /**
     * @return LocaleStats[]
     */
    public function process()
    {
        $masterLocale = $this->configFile->getMasterLocale();
        $statsPerLocale = [];
        foreach ($this->configFile->getLanguages() as $locale) {
            $statsPerLocale[$locale] = new LocaleStats($locale);
        }

        foreach ($this->translationsFiles as $translationFile) {
            foreach ($this->configFile->getLanguages() as $locale) {
                $this->statsPerFile($translationFile, $statsPerLocale[$locale]);
            }
        }

        return $statsPerLocale;
    }

    /**
     * @param  TranslationFileInterface $translationFile
     * @param  string                   $locale
     */
    private function statsPerFile(TranslationFileInterface $translationFile, LocaleStats $localeStats)
    {
        $toTranslateFile = $translationFile->getTranslationFileForLocale($localeStats->getLocale());
        $toTranslateFile->parse();

        $localeStats->addFilespath($toTranslateFile->getPath());

        $totalTranslation = $missingTranslation = 0;
        foreach ($translationFile->getTranslations() as $translation) {
            if ($toTranslateFile->isTranslationEmpty($translation->getKey())) {
                $missingTranslation++;
            }
            $totalTranslation++;
        }

        $localeStats->setTotalTranslationsPerFilepath($toTranslateFile->getPath(), $totalTranslation);
        $localeStats->setMissingTranslationsPerFilepath($toTranslateFile->getPath(), $missingTranslation);
    }
}