<?php

namespace DeMemory\DcatMailTool\Forms;

use Carbon\CarbonInterface;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;
use DeMemory\DcatMailTool\Models\Log;
use DeMemory\DcatMailTool\OrderShipped;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class Push extends Form
{
    public function handle(array $input)
    {
        $title  = $input['title'];
        $emails = $input['emails'];
        if (!$title)
            return $this->response()->error('邮件标题');
        if (!$emails)
            return $this->response()->error('请输入收件邮箱');

        foreach ($emails as $key => $v) {
            if (!filter_var($v, FILTER_VALIDATE_EMAIL) ?? false)
                return $this->response()->error('第' . ($key + 1) . '个邮箱错误');
        }

        $this->response()->success('发送中');

        $mailLogData = [];
        foreach ($emails as $key => $v) {

           Mail::to($v)->queue(new OrderShipped($input['title'], $input['content']));

            $mailLogData[] = [
                'title'        => $input['title'],
                'from_address' => $input['from_address'],
                'email'        => $v,
                'content'      => $input['content'],
                'operator'     => Admin::user()->username,
                'created_at'   => Carbon::now(config('app.timezone'))->format(CarbonInterface::DEFAULT_TO_STRING_FORMAT)
            ];

        }

        Log::query()->insert($mailLogData);

        return $this->response()->success('发送成功')->refresh('/mail-tool?link=2');
    }

    public function form()
    {
        $config = \DeMemory\DcatMailTool\Models\Config::config();
        config([
            'mail.default'      => $config['mailer'],
            'mail.mailers.smtp' => [
                'transport'    => $config['mailer'],
                'host'         => $config['host'],
                'port'         => $config['port'],
                'encryption'   => $config['encryption'],
                'username'     => $config['username'],
                'password'     => $config['password'],
                'timeout'      => null,
                'local_domain' => env('MAIL_EHLO_DOMAIN'),
            ],
            'mail.from'         => [
                'address' => $config['from_address'],
                'name'    => $config['from_name'],
            ],
        ]);

        $this->hidden('from_address', '发送地址')->default($config['from_address']);
        $this->text('title', '邮件标题')->setLabelClass(['asterisk']);
        $this->list('emails', '收件邮箱')->setLabelClass(['asterisk']);
        $this->editor('content', '邮件内容')->setLabelClass(['asterisk']);
    }
}
