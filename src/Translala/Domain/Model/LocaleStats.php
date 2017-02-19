<?php

namespace Translala\Domain\Model;

class LocaleStats
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var array
     */
    private $filespath = [];

    /**
     * @var integer
     */
    private $totalTranslationsPerFilepath;

    /**
     * @var integer
     */
    private $missingTranslationsPerFilepath;

    /**
     * @param string $locale the locale
     */
    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getFilespath()
    {
        return $this->filespath;
    }

    /**
     * @param string $filespath the filespath
     *
     * @return this
     */
    public function addFilespath($filespath)
    {
        $this->filespath[] = $filespath;

        return $this;
    }

    /**
     * @return this
     */
    public function setTotalTranslationsPerFilepath($filepath, $total)
    {
        $this->totalTranslationsPerFilepath[$filepath] = $total;

        return $this;
    }

    /**
     * @return this
     */
    public function setMissingTranslationsPerFilepath($filepath, $total)
    {
        $this->missingTranslationsPerFilepath[$filepath] = $total;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTotalTranslations()
    {
        return array_sum($this->totalTranslationsPerFilepath);
    }

    /**
     * @return integer
     */
    public function getTotalMissingTranslations()
    {
        return array_sum($this->missingTranslationsPerFilepath);
    }

    /**
     * @return array
     */
    public function geStatsPerFilepath()
    {
        $statsPerFile = [];
        foreach ($this->totalTranslationsPerFilepath as $filepath => $value) {
            $missing = (isset($this->missingTranslationsPerFilepath[$filepath])) ? $this->missingTranslationsPerFilepath[$filepath] : $value;
            $statsPerFile[$filepath] = ['total' => $value, 'missing' => $missing];
        }

        return $statsPerFile;
    }
}