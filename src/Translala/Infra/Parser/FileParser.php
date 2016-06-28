<?php

namespace Translala\Infra\Parser;

use Symfony\Component\Yaml\Yaml;
use Translala\Domain\Model\Translation;

class FileParser
{
    /**
     * @var string
     */
    private $filepath;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var language
     */
    private $language;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var array
     */
    private $keypath;

    /**
     * @var array
     */
    private $translations = [];

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
     * @return array<TranslationInterface>
     */
    public function parse()
    {
        $yamlParser = new Yaml();
        $datas = $yamlParser->parse(file_get_contents($this->filepath));
        $this->loadTranslationData($datas);

        return $this->translations;
    }

    /**
     * @param  array $datas
     */
    private function loadTranslationData($datas, $prefix = null)
    {
        foreach ($datas as $key => $value) {
            if (is_array($value)) {
                $prefix = trim($prefix . '.' . $key, '.');
                $this->loadTranslationData($value, $prefix);
            } else {
                $key = $prefix . '.' . $key;
                $this->translations[] = new Translation($key, $value, $this->language, $this->domain);
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