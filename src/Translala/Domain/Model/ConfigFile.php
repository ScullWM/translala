<?php

namespace Translala\Domain\Model;

use Symfony\Component\Yaml\Parser;
use Translala\Domain\Model\ConfigFileInterface;

class ConfigFile implements ConfigFileInterface
{
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
        return $this->data[ConfigFileInterface::PATHS_KEY];
    }

    /**
     * @return string
     */
    public function getMasterLocale()
    {
        return $this->data[ConfigFileInterface::MASTER_LOCALE_KEY];
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->data[ConfigFileInterface::LANGUAGES_KEY];
    }

    /**
     * @return string
     */
    public function getProjectPath()
    {
        return $this->data[ConfigFileInterface::PROJECT_PATH];
    }

    /**
     * @return bool
     */
    public function getDirectoryManagement()
    {
        if (isset($this->data[ConfigFileInterface::PROJECT_DIRECTORY_MANAGEMENT])) {
            return $this->data[ConfigFileInterface::PROJECT_DIRECTORY_MANAGEMENT];
        }

        return false;
    }

    /**
     * @return array
     */
    public function getOthersLanguages()
    {
        $allLanguages = $this->getLanguages();
        if(($key = array_search($this->getMasterLocale(), $allLanguages)) !== false) {
            unset($allLanguages[$key]);
        }

        return $allLanguages;
    }

    /**
     * @return string
     */
    public function getExportPath()
    {
        return $this->data[ConfigFileInterface::EXPORT_PATH_KEY];
    }

    /**
     * @return array
     */
    public function getApiKey()
    {
        return $this->data[ConfigFileInterface::API_KEY];
    }
}