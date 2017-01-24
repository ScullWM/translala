<?php

namespace Translala\Domain\Processor;

use Translala\Domain\Model\CommonTranslation;
use Translala\Domain\Model\TranslationInterface;

class CommonProcessor
{
    /**
     * @return array
     */
    protected $translationsCounter = [];

    /**
     * @return array
     */
    public function getTranslationsListing()
    {
        uasort($this->translationsCounter, function($b, $a) { return strcmp($a->getCounter(), $b->getCounter()); });

        return $this->translationsCounter;
    }

    /**
     * @param  TranslationInterface $translation
     */
    public function process(TranslationInterface $translation)
    {
        $translationKey = md5($this->cannonicalize($translation->getValue()));

        if (!isset($this->translationsCounter[$translationKey])) {
            $this->translationsCounter[$translationKey] = new CommonTranslation($translationKey, $translation->getValue());
        }

        $this->translationsCounter[$translationKey]->increment($translation->getKey());
    }

    /**
     * @param  string $key
     * @return string
     */
    private function cannonicalize($key)
    {
        return strtolower(trim($key));
    }
}