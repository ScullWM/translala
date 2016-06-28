<?php

namespace Translala\Infra\Job;

class TranslateJob
{
    /**
     * @var array
     */
    private $translationsFiles;

    /**
     * @param array $translationsFiles
     */
    public function __construct(array $translationsFiles)
    {
        $this->translationsFiles = $translationsFiles;
    }

    public function process()
    {
        foreach ($this->translationsFiles as $translationFile) {
            foreach ($translationFile->getTranslations() as $translation) {
                var_dump($translation->getKeypath());
                exit();
            }
        }
    }
}