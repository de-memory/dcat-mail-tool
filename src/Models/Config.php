<?php

namespace DeMemory\DcatMailTool\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'mail_config';

    protected $fillable = ['value'];

    public static function config()
    {
        $model = self::query()->where('key', 'MAIL_CONFIG')->first();

        $config = json_decode($model->value ?? '', true);

        return [
            'mailer'       => $config ? $config['mailer'] : env('MAIL_MAILER', 'smtp'),
            'host'         => $config ? $config['host'] : env('MAIL_HOST', 'smtp.mailgun.org'),
            'port'         => $config ? $config['port'] : env('MAIL_PORT', 587),
            'username'     => $config ? $config['username'] : env('MAIL_USERNAME'),
            'password'     => $config ? $config['password'] : env('MAIL_PASSWORD'),
            'encryption'   => $config ? $config['encryption'] : env('MAIL_ENCRYPTION', 'tls'),
            'from_address' => $config ? $config['from_address'] : env('MAIL_USERNAME'),
            'from_name'    => $config ? $config['from_name'] : env('MAIL_FROM_NAME', 'Example'),
        ];
    }
}
