<?php

namespace Translala\Domain\Model;

use Symfony\Component\Yaml\Parser;

class ConfigFile implements ConfigFileInteface
{
    const PATHS_KEY         = 'paths';
    const MASTER_LOCALE_KEY = 'master_language';
    const LANGUAGES_KEY     = 'languages';
    const EXPORT_PATH_KEY   = 'export_path';


    /**
     * @var string
     */
    private $filepath;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param string $filepath
     */
    public function __construct($filepath)
    {
        $this->filepath = $filepath;

        $yamlParser = new Parser();
        $this->data = $yamlParser->parse(file_get_contents($filepath));
    }

    /**
     * @return string
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getTranslationPaths()
    {
        return $this->data[self::PATHS_KEY];
    }

    /**
     * @return string
     */
    public function getMasterLocale()
    {
        return $this->data[self::MASTER_LOCALE_KEY];
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->data[self::LANGUAGES_KEY];
    }

    /**
     * @return string
     */
    public function getExportPath()
    {
        return $this->data[self::EXPORT_PATH_KEY];
    }
}