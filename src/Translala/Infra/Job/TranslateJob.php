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
            echo $translationFile->getPath();
            foreach ($translationFile->getTranslations() as $translation) {
                // echo $translation->getKey();
                echo '-';
            }
        }
    }
}