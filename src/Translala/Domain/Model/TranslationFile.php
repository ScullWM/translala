<?php

namespace Translala\Domain\Model;

use Translala\Domain\Model\TranslationInterface;
use Translala\Domain\Parser\ParserInterface;
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
     * @var string
     */
    private $currentLocale;

    /**
     * @param string $path
     * @param ParserInterface
     * @param string
     */
    public function __construct($path, ParserInterface $fileParser, $currentLocale)
    {
        $this->path          = $path;
        $this->fileParser    = $fileParser;
        $this->currentLocale = $currentLocale;
    }

    /**
     * @param  string $locale
     * @return string
     */
    private function getPathForLocale($locale)
    {
        $distantLocale = sprintf($this->fileParser->getStrategyName(), $locale);
        $currentLocale = sprintf($this->fileParser->getStrategyName(), $this->currentLocale);

        return str_replace($currentLocale, $distantLocale, $this->path);
    }

    /**
     * @param  string  $locale
     * @return boolean
     */
    public function isMissingForLocale($locale)
    {
        return (bool) file_exists($this->getPathForLocale($locale));
    }

    /**
     * @return null
     */
    public function parse()
    {
        $this->translations = $this->fileParser->parse($this->getPath());
    }

    /**
     * @return string
     */
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

    /**
     * @param  string $locale
     * @return TranslationFileInterface
     */
    public function getTranslationFileForLocale($locale)
    {
        return new TranslationFile($this->getPathForLocale($locale), new FileParser($this->getPathForLocale($locale)), $locale);
    }

    /**
     * @param  string  $key
     * @return boolean
     */
    public function isTranslationEmpty($key)
    {
        if (!isset($this->translations[$key])) {
            return true;
        }

        return (bool) (empty($this->translations[$key]->getValue()));
    }

    /**
     * Dump translation in new file
     *
     * @return null
     */
    public function dump()
    {
        $datas = [];
        foreach ($this->translations as $translation) {
            $datas = array_merge_recursive($translation->getKeypath(), $datas);
        }

        $this->fileParser->dump($datas, $this->getPath());
    }

    /**
     * @param  TranslationInterface $translation
     * @return this
     */
    public function updateTranslation(TranslationInterface $translation)
    {
        $this->translations[$translation->getKey()] = $translation;

        return $this;
    }
}