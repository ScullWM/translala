<?php

namespace Translala\Domain\Model;

interface TranslationFileInterface
{
    public function getFilepath();

    public function getContent();

    public function getTranslations();
}