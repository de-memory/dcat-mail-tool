<?php

namespace DeMemory\DcatMailTool\Forms;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;

class Config extends Form
{
    public function handle(array $input)
    {
        if (!in_array($input['port'], [25, 109, 110, 143, 465, 995, 993, 994]))
            return $this->response()->error('端口错误');

        $model = \DeMemory\DcatMailTool\Models\Config::query()->where('key', 'MAIL_CONFIG')->first();
        if (!$model)
            \DeMemory\DcatMailTool\Models\Config::query()->insert(['key' => 'MAIL_CONFIG', 'value' => json_encode($input)]);
        else
            $model->update(['value' => json_encode($input)]);


        return $this->response()->success(__('admin.update_succeeded'));
    }

    public function form()
    {
        $formId = $this->getElementId();

        Admin::script(
            <<<JS
        // 给发送地址赋值
        $('#$formId').find('.field_username').on('input propertychange',function(){
            $('#$formId').find('.field_from_address').val($(this).val())
        });
JS
        );
        $this->text('mailer', '驱动')->required()->help('邮件的驱动类型，默认采用smtp');
        $this->text('host', '服务器地址')->required();
        $this->text('port', '端口')->required()->help('支持端口：25、109、110、143、465、995、993、994');
        $this->email('username', '发件人邮箱')->required();
        $this->password('password', '邮箱密码')->required()->help('smtp授权码或邮箱登录密码');
        $this->text('encryption', '加密方式');
        $this->email('from_address', '发送地址')->readOnly()->help('一般同发件人邮箱');
        $this->text('from_name', '发送人')->required();
    }

    public function default(): array
    {
        return \DeMemory\DcatMailTool\Models\Config::config();
    }
}
