<?php

namespace Translala\Infra\Parser;

use Symfony\Component\Yaml\Yaml;
use Translala\Domain\Model\Translation;
use Translala\Domain\Parser\ParserInterface;

class FileParser implements ParserInterface
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

    public function dump($datas)
    {
        $yamlParser  = new Yaml();
        $yamlContent = $yamlParser->dump($datas, 100);
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
                $this->translations[$key] = new Translation($key, $value, $this->language, $this->domain);
            }
        }
    }

    /**
     * @return string
     */
    public function getStrategyName()
    {
        return '%s.yml';
    }

    /**
     * @return array<TranslationInterface>
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}