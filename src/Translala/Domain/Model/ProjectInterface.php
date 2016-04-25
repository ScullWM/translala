<?php

namespace Translala\Domain\Model;

interface ProjectInterface
{
    public function getLocales();

    public function getConfigFile();
}