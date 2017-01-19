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

        if (!isset($apiKeys['google'])) {
            throw new \Exception("GoogleTranslator api key is missing");
        }

        $this->translationClient = new Translator();
        $this->translationClient->addTranslatorService(new GoogleTranslator($apiKeys['google']));
        $masterLocale = $this->configFile->getMasterLocale();

        foreach ($this->translationsFiles as $translationFile) {
            foreach ($this->configFile->getLanguages() as $locale) {
                $this->translateFile($translationFile, $locale);
            }
        }
    }

    private function translateFile(TranslationFileInterface $translationFile, $locale)
    {
        foreach ($translationFile->getTranslations() as $translation) {

            $translationString = $this->translationClient->translate($translation->getValue(), $translation->getLanguage(), $locale);
            var_dump($translationString);
            exit();
        }
    }
}