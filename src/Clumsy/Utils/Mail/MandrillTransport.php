<?php

namespace Clumsy\Utils\Mail;

use Swift_Mime_Message;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Transport\MandrillTransport as BaseMandrill;

class MandrillTransport extends BaseMandrill
{
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $message->getHeaders()->addTextHeader('X-MC-Subaccount', Config::get('services.mandrill.subaccount'));

        return parent::send($message, $failedRecipients);
    }
}
