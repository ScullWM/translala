<?php

namespace Translala\Domain\Model;

interface TranslationFileInterface
{
    public function parse();

    public function dump();
}