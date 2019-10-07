<?php

namespace Translala\Domain\Model;

class Project implements ProjectInterface
{
    private $locales;
    private $configFile;

    public function getLocales()
    {
        return $this->locales;
    }

    public function getConfigFile()
    {
        return $this->configFile;
    }
}
