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
            foreach ($this->configFile->getOthersLanguages() as $locale) {
                $this->translateFile($translationFile, $locale);
            }
        }
    }

    /**
     * @param  TranslationFileInterface $translationFile
     * @param  string                   $locale
     */
    private function translateFile(TranslationFileInterface $translationFile, $locale)
    {
        $countUpdatedTranslation = 0;

        $toTranslateFile = $translationFile->getTranslationFileForLocale($locale);
        foreach ($translationFile->getTranslations() as $translation) {
            if ($toTranslateFile->isTranslationEmpty($translation->getKey())) {

                $translatedValue = $this->translationClient->translate($translation->getValue(), $translation->getLanguage(), $locale);
                $updatedTranslation = clone($translation);
                $updatedTranslation->setValue($translatedValue);

                $toTranslateFile->updateTranslation($updatedTranslation);
                $countUpdatedTranslation++;
            }
        }

        if ($countUpdatedTranslation > 0) {
            $toTranslateFile->dump();
        }
    }

    private function checkKey($apiKeys)
    {
        if (empty($apiKeys['google'])) {
            throw new \Exception(sprintf("GoogleTranslator api key is missing: %s", $apiKeys['google']));
        }
    }
}