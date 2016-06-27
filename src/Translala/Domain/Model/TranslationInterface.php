<?php

namespace Translala\Domain\Model;

interface TranslationInterface
{
    const DEFAULT_DOMAIN = 'message';

    public function getKey();

    public function getValue();

    public function getLanguage();

    public function getDomain();
}