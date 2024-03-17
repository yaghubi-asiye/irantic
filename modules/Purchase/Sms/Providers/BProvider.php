<?php

namespace Modules\Purchase\Sms\Providers;

use Illuminate\Support\Facades\Log;
use Modules\Purchase\Sms\SmsInterface;

class BProvider implements SmsInterface
{

    public function sendSms(string $mobile, string $message): bool
    {
        Log::info('Sending SMS via Provider B');
        return true;
    }
}
