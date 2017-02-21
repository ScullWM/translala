<?php

namespace Translala\Infra\Parser;

use Translala\Domain\Model\Translation;

class AbstractFileParser
{
    /**
     * @var string
     */
    protected $filepath;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var language
     */
    protected $language;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var array
     */
    protected $keypath;

    /**
     * @var array
     */
    protected $translations = [];

    /**
     * @param string $filepath
     */
    public function __construct($filepath)
    {
        $this->filepath  = $filepath;
        $exploded = explode('.', $filepath);

        $this->domain = $exploded[0];
        $this->language = $exploded[1];
        $this->extension = $exploded[2];
    }

    /**
     * @param  array $datas
     */
    protected function loadTranslationData($datas, $prefix = null, $iteration = 0)
    {
        foreach ($datas as $key => $value) {
            if (is_array($value)) {
                $tmpPrefix = trim($prefix . '.' . $key, '.');
                $iteration++;
                $this->loadTranslationData($value, $tmpPrefix, $iteration);
            } else {
                $tmpPrefix = $prefix . '.' . $key;

                $this->translations[$tmpPrefix] = new Translation($tmpPrefix, $value, $this->language, $this->domain);
            }
            if ($iteration == 0) {
                $prefix = '';
                $iteration = 0;
            }
        }
    }

    /**
     * @return array<TranslationInterface>
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}