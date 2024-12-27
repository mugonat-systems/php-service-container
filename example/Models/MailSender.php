<?php

namespace Mugonat\Container\Example\Models;

class MailSender {
    public function send($username): void
    {
        echo "Email was sent to $username \n";
    }
}
