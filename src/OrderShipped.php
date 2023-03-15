<?php

namespace DeMemory\DcatMailTool;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $view = 'de-memory.dcat-mail-tool::index';

    public function __construct(string $subject, string $content)
    {
        $this->subject($subject);

        $this->with(['content' => $content]);
    }

    public function build(): OrderShipped
    {
        return $this->markdown($this->view);
    }
}
