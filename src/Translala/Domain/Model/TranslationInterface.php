<?php

namespace Translala\Domain\Model;

interface TranslationInterface
{
    public function getKey();

    public function getValue();

    public function getLocale();

    public function getDomain();
}