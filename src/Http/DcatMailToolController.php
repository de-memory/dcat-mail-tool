<?php

namespace DeMemory\DcatMailTool\Http;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;
use DeMemory\DcatMailTool\Forms\Config;
use DeMemory\DcatMailTool\Forms\Push;
use DeMemory\DcatMailTool\Tables\Log;
use Illuminate\Routing\Controller;

class DcatMailToolController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->body(function (Row $row) {
                $tab = new Tab();
                $tab->add('发送邮件', new Push(), true);
                $tab->add('发送日志', new Log());
                $tab->add('配置', new Config());
                $row->column(12, $tab->withCard());
            });
    }
}
