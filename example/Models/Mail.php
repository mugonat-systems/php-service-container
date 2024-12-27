<?php

namespace Mugonat\Container\Example\Models;

class Mail
{
    private $mailSender;

    public function __construct(MailSender $mailSender)
    {
        $this->mailSender = $mailSender;
    }

    public function sendMail($username)
    {
        $this->mailSender->send($username);
    }
}