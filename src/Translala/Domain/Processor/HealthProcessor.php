<?php

namespace Translala\Domain\Processor;

use Translala\Domain\Exception\HealthException;

class HealthProcessor
{
    /**
     * @var array
     */
    private $healthGoalsPerLocale;

    public function __construct(array $healthGoalsPerLocale = [])
    {
        $this->healthGoalsPerLocale = $healthGoalsPerLocale;
    }

    /**
     * @param  StatsJob $statsJob
     * @return array
     */
    public function process(array $statsPerLocale = [])
    {
        $missingTranslationPercentagePerLocale = [];

        foreach ($statsPerLocale as $locale) {
            $percentage = (($locale->getTotalTranslations()-$locale->getTotalMissingTranslations())/$locale->getTotalTranslations())*100;

            if (isset($this->healthGoalsPerLocale[$locale->getLocale()]) && $percentage < $this->healthGoalsPerLocale[$locale->getLocale()]) {
                throw new HealthException(
                    sprintf("Health fail for locale %s (Get %s while require at minial %s)", $locale->getLocale(), $percentage, $this->healthGoalsPerLocale[$locale->getLocale()])
                );

            }
        }
    }
}