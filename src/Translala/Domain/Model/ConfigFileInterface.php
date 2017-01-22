<?php

namespace Translala\Domain\Model;

interface ConfigFileInterface
{
    const PATHS_KEY         = 'paths';
    const MASTER_LOCALE_KEY = 'master_language';
    const LANGUAGES_KEY     = 'languages';
    const EXPORT_PATH_KEY   = 'export_path';
    const API_KEY           = 'api';

    public function getFilepath();
}