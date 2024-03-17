<?php

namespace Modules\Purchase\Sms;

interface SmsInterface
{
    public function sendSms(string $mobile, string $message): bool;
}
