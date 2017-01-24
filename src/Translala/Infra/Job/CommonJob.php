<?php

namespace Translala\Infra\Job;

use Translala\Domain\Model\ConfigFileInterface;
use Translala\Domain\Model\TranslationFileInterface;
use Translala\Domain\Processor\CommonProcessor;
use Translation\Translator\Translator;

class CommonJob
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
     * @var CommonProcessor
     */
    private $commonProcessor;

    /**
     * @param array $translationsFiles
     */
    public function __construct(array $translationsFiles, ConfigFileInterface $configFile)
    {
        $this->translationsFiles = $translationsFiles;
        $this->configFile        = $configFile;
    }

    /**
     * @return CommonProcessor
     */
    public function process()
    {
        $commonProcessor = new CommonProcessor();
        foreach ($this->translationsFiles as $translationFile) {
            array_map([$commonProcessor, 'process'], $translationFile->getTranslations());
        }

        return $commonProcessor;
    }
}