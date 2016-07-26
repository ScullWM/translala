<?php

namespace Translala\Infra\Job;

use Stichoza\GoogleTranslate\TranslateClient;
use Translala\Domain\Model\ConfigFileInterface;
use Translala\Domain\Model\TranslationFileInterface;

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
     * @param array $translationsFiles
     */
    public function __construct(array $translationsFiles, ConfigFileInterface $configFile)
    {
        $this->translationsFiles = $translationsFiles;
        $this->configFile        = $configFile;
    }

    public function process()
    {
        $tr = new TranslateClient();
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
            $tr->setSource($masterLocale)->setTarget('ka')->translate('Goodbye');


            var_dump($translation->getKeypath());
            exit();
        }
    }
}