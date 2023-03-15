<?php

namespace DeMemory\DcatMailTool\Tables;

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Widgets\Modal;

class Log extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new \DeMemory\DcatMailTool\Models\Log(), function (Grid $grid) {

            $grid->disableRowSelector()->disableCreateButton()->disableActions();

            $grid->model()->orderByDesc('id');

            $grid->column('id')->sortable();

            $grid->column('title', '标题');

            $grid->column('from_address', '发送地址');

            $grid->column('email', '收件邮箱');

            $grid->column('content', '内容')->display(function ($column) {
                return Modal::make()
                    ->xl()
                    ->scrollable()
                    ->title("内容")
                    ->body("<textarea$column</textarea>")
                    ->button('查看内容');
            });

            $grid->column('operator', '操作人');

            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->where('keyword_ncss', function ($query) {
                    $query->where('title', 'like', "{$this->input}%")
                        ->orWhere('from_address', 'like', "{$this->input}%")
                        ->orWhere('email', 'like', "{$this->input}%")
                        ->orWhere('operator', 'like', "{$this->input}%");
                }, '关键字')->width(3)->placeholder('标题/发送地址/收件邮箱/操作人');
            });
        });
    }
}
