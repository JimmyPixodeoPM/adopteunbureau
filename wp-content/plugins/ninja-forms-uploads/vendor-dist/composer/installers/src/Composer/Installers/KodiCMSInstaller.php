<?php

namespace NF_FU_VENDOR\Composer\Installers;

class KodiCMSInstaller extends BaseInstaller
{
    protected $locations = array('plugin' => 'cms/plugins/{$name}/', 'media' => 'cms/media/vendor/{$name}/');
}
