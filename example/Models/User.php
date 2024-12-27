<?php

namespace Mugonat\Container\Example\Models;

class User
{
    private $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function sendMail($username)
    {
        $this->mail->sendMail($username);
    }
}