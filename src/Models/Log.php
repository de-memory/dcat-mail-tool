<?php

namespace DeMemory\DcatMailTool\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'mail_log';
}
