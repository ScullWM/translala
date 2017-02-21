<?php

namespace Translala\App\Loader;

use Translala\Domain\Model\CommandContext;
use Translala\Domain\Model\ConfigFile;
use Translala\Domain\Model\TranslationFile;
use Translala\Infra\Parser\JsonFileParser;
use Translala\Infra\Parser\PhpFileParser;
use Translala\Infra\Parser\YamlFileParser;

class ProjectLoader implements LoaderInterface
{
    /**
     * @var ConfigFileInterface
     */
    private $configFile;

    /**
     * @var array
     */
    private $translationsFiles = [];

    /**
     * @param string $filepath
     */
    public function __construct($filepath)
    {
        $this->configFile = new ConfigFile($filepath);
    }

    /**
     * @param  CommandContext $context
     */
    public function load(CommandContext $context)
    {
        $translationPaths = $this->configFile->getTranslationPaths();

        if ($directoryManagement = $this->configFile->getDirectoryManagement()) {
            $regex = $this->configFile->getMasterLocale() . DIRECTORY_SEPARATOR . '*.{yml,php,json}';
        } else {
            $regex = '*.' . $this->configFile->getMasterLocale() . '.{yml,php,json}';
        }

        foreach ($translationPaths as $path) {
            foreach (glob($path . $regex, GLOB_BRACE) as $translationFile) {
                $translationFileModel = new TranslationFile($translationFile, $this->getFileParser($translationFile), $this->configFile->getMasterLocale());
                $translationFileModel->parse();
                $this->translationsFiles[] = $translationFileModel;
            }
        }
    }

    /**
     * @param  string $translationFilePath
     * @return FileParserInterface
     */
    private function getFileParser($translationFilePath)
    {
        $fileInfo = pathinfo($translationFilePath);
        switch ($fileInfo['extension']) {
            case 'yml':
                $fileParser = new YamlFileParser($translationFilePath);
                break;

            case 'php':
                $fileParser = new PhpFileParser($translationFilePath);
                break;

            case 'json':
                $fileParser = new JsonFileParser($translationFilePath);
                break;
        }

        return $fileParser;
    }

    /**
     * @return array
     */
    public function getTranslationFiles()
    {
        return $this->translationsFiles;
    }

    /**
     * @return ConfigFileInterface
     */
    public function getConfig()
    {
        return $this->configFile;
    }

    /**
     * @param  string $viewPath
     * @param  array  $datas
     */
    public function render($viewPath, array $datas)
    {
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../Templates');
        $twig = new \Twig_Environment($loader, array('cache' => false));

        $initDatas = [
            'config' => $this->configFile,
        ];

        $exportPath = str_replace('.twig', '', $this->configFile->getExportPath() . DIRECTORY_SEPARATOR . $viewPath);
        file_put_contents($exportPath, $twig->render($viewPath, array_merge($initDatas, $datas)));
    }
}