<?php

namespace Translala\Infra\Job;

use Translala\Domain\Model\ConfigFileInterface;
use Translala\Domain\Model\TranslationFileInterface;
use Translation\Translator\Service\GoogleTranslator;
use Translation\Translator\Translator;

class TranslateJob
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
     * @var TranslatorService
     */
    private $translationClient;

    /**
     * @param array $translationsFiles
     */
    public function __construct(array $translationsFiles, ConfigFileInterface $configFile)
    {
        $this->translationsFiles = $translationsFiles;
        $this->configFile        = $configFile;
    }

    public function process()
    {
        $apiKeys = $this->configFile->getApiKey();
        $this->checkKey($apiKeys);

        $this->translationClient = new Translator();
        $this->translationClient->addTranslatorService(new GoogleTranslator($apiKeys['google']));
        $masterLocale = $this->configFile->getMasterLocale();

        // var_dump($this->translationsFiles, $this->configFile->getLanguages());
        // exit();

        foreach ($this->translationsFiles as $translationFile) {
            foreach ($this->configFile->getLanguages() as $locale) {
                $this->translateFile($translationFile, $locale);
            }
        }
    }

    /**
     * @param  TranslationFileInterface $translationFile
     * @param  [type]                   $locale
     * @return [type]
     */
    private function translateFile(TranslationFileInterface $translationFile, $locale)
    {
        $updatedTranslation = 0;

        if ($translationFile->isMissingForLocale($locale)) {
            $toTranslateFile = $translationFile->getTranslationFileForLocale($locale);
        }

        foreach ($translationFile->getTranslations() as $translation) {
                var_dump($translationFile->getTranslations());
                exit();
            if ($translation->isEmpty()) {


                $this->translationClient->translate($translation->getValue(), $translation->getLanguage(), $locale);
                $updatedTranslation++;
            }
        }

        if ($updatedTranslation > 0) {

            var_dump($updatedTranslation);
            exit();
        }
    }

    private function checkKey($apiKeys)
    {
        if (empty($apiKeys['google'])) {
            throw new \Exception(sprintf("GoogleTranslator api key is missing: %s", $apiKeys['google']));
        }
    }
}