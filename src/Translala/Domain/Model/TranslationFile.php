<?php

namespace Translala\Domain\Model;

use Translala\Domain\Model\TranslationInterface;
use Translala\Infra\Parser\FileParser;

class TranslationFile implements TranslationFileInterface
{
    /**
     * @var string
     */
    private $path;

    private $fileParser;

    /**
     * @var array
     */
    private $translations = [];

    /**
     * @param string $path
     */
    public function __construct($path, FileParser $fileParser)
    {
        $this->path       = $path;
        $this->fileParser = $fileParser;
    }

    public function isMissingForLocale($locale)
    {
        return;
    }

    public function parse()
    {
        $this->fileParser->parse();
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array<TranslationInterface>
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}