<?php

namespace Translala\Domain\Model;

class CommonTranslation
{
    /**
     * @var string
     */
    protected $hash;

    /**
     * @var int
     */
    protected $counter;

    /**
     * @var array
     */
    protected $keysReferences;

    /**
     * @var string
     */
    protected $translation;

    /**
     * @param string $hash
     */
    public function __construct($hash, $translation)
    {
        $this->hash = $hash;
        $this->counter = 0;
        $this->keysReferences = [];
        $this->translation = $translation;
    }

    /**
     * @param  string $reference
     * @return this
     */
    public function increment($reference)
    {
        $this->counter++;
        $this->keysReferences[] = $reference;

        return $this;
    }

    /**
     * @return int
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @return int
     */
    public function getReferences()
    {
        return $this->keysReferences;
    }

    /**
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }
}