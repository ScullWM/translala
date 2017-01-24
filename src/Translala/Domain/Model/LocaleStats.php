<?php

namespace Translala\Domain\Model;

class LocaleStats
{
    private $locale;

    private $filespath = [];

    private $totalTranslationsPerFilepath;

    private $missingTranslationsPerFilepath;

    /**
     * @param string $locale the locale
     */
    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Gets the value of locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Gets the value of filespath.
     *
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
     *
     * @return this
     */
    public function setTotalTranslationsPerFilepath($filepath, $total)
    {
        $this->totalTranslationsPerFilepath[$filepath] = $total;

        return $this;
    }

    /**
     *
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