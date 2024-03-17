<?php

namespace Modules\Purchase\Sms;

class SmsService implements SmsInterface
{
    protected $smsProviders;

    public function __construct(array $smsProviders)
    {
        $this->smsProviders = $smsProviders;
    }

    public function sendSms(string $mobile, string $message): bool
    {
        foreach ($this->smsProviders as $smsProvider) {
            if ($smsProvider->sendSms($mobile, $message)) {
                return true;
            }
        }
        return false;
    }
}
