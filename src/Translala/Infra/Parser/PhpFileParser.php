<?php

namespace Translala\Infra\Parser;

use Translala\Domain\Parser\ParserInterface;

class PhpFileParser extends AbstractFileParser implements ParserInterface
{
    /**
     * @return string
     */
    public function getStrategyName()
    {
        return '%s.php';
    }

    /**
     * @return array<TranslationInterface>
     */
    public function parse($filepath = null)
    {
        $filepath = ($filepath) ? $filepath : $this->filepath;

        if (file_exists($filepath)) {
            $datas = require($filepath);
            $this->loadTranslationData($datas);
        } else {
            $this->translations = [];
        }

        return $this->translations;
    }

    /**
     * @param  array  $datas
     * @param  string $path
     */
    public function dump(array $datas, $path)
    {
        $phpContent = "<?php\n\nreturn ".var_export($datas, true).";\n";

        file_put_contents($path, $phpContent);
    }
}