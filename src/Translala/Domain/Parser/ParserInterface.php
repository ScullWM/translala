<?php

namespace Translala\Domain\Parser;

interface ParserInterface
{
    public function parse();

    public function dump(array $datas, $path);
}