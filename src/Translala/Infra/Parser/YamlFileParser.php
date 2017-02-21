<?php

namespace Translala\Infra\Parser;

use Symfony\Component\Yaml\Yaml;
use Translala\Domain\Parser\ParserInterface;

class YamlFileParser extends AbstractFileParser implements ParserInterface
{
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
    public function parse($filepath = null)
    {
        $filepath = ($filepath) ? $filepath : $this->filepath;

        $yamlParser = new Yaml();

        if (file_exists($filepath)) {
            $datas = $yamlParser->parse(file_get_contents($filepath));
            $this->loadTranslationData($datas);
        } else {
            $this->translations = [];
        }

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
}