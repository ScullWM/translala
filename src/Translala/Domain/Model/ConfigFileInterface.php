<?php

namespace Translala\Domain\Model;

interface ConfigFileInterface
{
    const PATHS_KEY         = 'paths';
    const MASTER_LOCALE_KEY = 'master_language';
    const LANGUAGES_KEY     = 'languages';
    const EXPORT_PATH_KEY   = 'export_path';
    const API_KEY           = 'api';
    const PROJECT_PATH      = 'project_path';
    const PROJECT_DIRECTORY_MANAGEMENT = 'directory_management';

    public function getFilepath();

    public function getTranslationPaths();

    public function getMasterLocale();

    public function getLanguages();

    public function getProjectPath();

    public function getOthersLanguages();

    public function getExportPath();
}