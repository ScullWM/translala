<?php

namespace Translala\Domain\Model;

class Translation implements TranslationInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $domain;

    /**
     * @param string $key
     * @param string $value
     * @param string $language
     * @param string $domain
     */
    public function __construct($key, $value, $language, $domain = self::DEFAULT_DOMAIN)
    {
        $this->key      = $key;
        $this->value    = $value;
        $this->language = $language;
        $this->domain   = $domain;
    }

    /**
     * Gets the value of key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Gets the value of value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets the value of language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
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
     * @return array
     */
    public function getKeypath()
    {
        $array = (!empty($this->getValue())) ? $this->getValue() : '~';
        foreach (array_reverse(explode('.', $this->key)) as $arr) {
            $array = [$arr => $array];
        }

        return $array;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->getValue());
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}