<?php

namespace Translala\Domain\Model;

class TranslationFile implements TranslationFileInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function isMissingForLocale($locale)
    {
        return;
    }
}