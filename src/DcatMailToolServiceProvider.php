<?php

namespace DeMemory\DcatMailTool;

use Dcat\Admin\Extend\ServiceProvider;

class DcatMailToolServiceProvider extends ServiceProvider
{
    protected $menu = [
        [
            'title' => '邮箱工具',
            'uri'   => 'dcat-mail-tool',
            'icon'  => 'feather icon-mail',
        ],
    ];

    public function register()
    {
        //
    }

    public function init()
    {
        parent::init();

        //

    }
}
