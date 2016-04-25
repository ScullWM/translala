<?php

namespace Translala\Domain\Model;

class CommandContext
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $locale;

    /**
     * @param string $domain
     * @param string $locale
     */
    public function __construct($domain, $locale)
    {
        $this->domain = $domain;
        $this->locale = $locale;
    }

    /**
     * Gets the value of domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
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
}