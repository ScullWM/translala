<?php

namespace Translala\Infra\Parser;

use Translala\Domain\Parser\ParserInterface;

class JsonFileParser extends AbstractFileParser implements ParserInterface
{
    /**
     * @return string
     */
    public function getStrategyName()
    {
        return '%s.json';
    }

    /**
     * @return array<TranslationInterface>
     */
    public function parse($filepath = null)
    {
        $filepath = ($filepath) ? $filepath : $this->filepath;

        if (file_exists($filepath)) {
            $datas = json_decode($filepath);
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
        file_put_contents($path, json_encode($datas));
    }
}