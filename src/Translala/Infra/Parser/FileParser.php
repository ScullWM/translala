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

    /**
     * @param  array  $datas
     * @param  string $path
     */
    public function dump(array $datas, $path)
    {
        $yamlParser  = new Yaml();
        $yamlContent = $yamlParser->dump($datas, 100);

        file_put_contents($path, $yamlContent);
    }

    /**
     * @param  array $datas
     */
    private function loadTranslationData($datas, $prefix = null, $iteration = 0)
    {
        foreach ($datas as $key => $value) {
            if (is_array($value)) {
                $tmpPrefix = trim($prefix . '.' . $key, '.');
                $iteration++;
                $this->loadTranslationData($value, $tmpPrefix, $iteration);
            } else {
                $prefix = $prefix . '.' . $key;

                $this->translations[$prefix] = new Translation($prefix, $value, $this->language, $this->domain);
            }
            if ($iteration == 0) {
                $prefix = '';
                $iteration = 0;
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