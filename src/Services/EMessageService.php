<?php
namespace EMessage\Services;

use EMessage\Contracts\EMessageInterface;
use EMessage\Exceptions\EMessageException;
use Illuminate\Support\Facades\Http;

class EMessageService implements EMessageInterface
{
    private string $account_sid;
    private string $auth_token;
    private string $send_number;
    private string $service_sid;

    public function __construct(string $account_sid, string $auth_token, string $send_number, string $service_sid)
    {
        $this->account_sid = $account_sid;
        $this->auth_token = $auth_token;
        $this->send_number = $send_number;
        $this->service_sid = $service_sid;
    }

    /**
     * Send Text Message to a number
     * @throws EMessageException
     */
    public function send_sms_use_phone(string $p_mobile, string $p_message, string $p_send_num = null): array
    {
        $from = $p_send_num ?? $this->send_number;

        return $this->send_sms($p_mobile, $p_message, 'From', $from);
    }

    /**
     * @throws EMessageException
     */
    public function send_sms_use_service(string $p_mobile, string $p_message, string $p_service = null): array
    {
        $from = $p_service ?? $this->service_sid;

        return $this->send_sms($p_mobile, $p_message, 'MessagingServiceSid', $from);
    }

    /**
     * @throws EMessageException
     */
    private function send_sms(string $p_mobile, string $p_message, string $p_from_key, string $p_from_value): array
    {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->account_sid}/Messages.json";

        try {
            $response = Http::withBasicAuth($this->account_sid, $this->auth_token)
                ->asForm()
                ->post($url, [
                    $p_from_key => $p_from_value,
                    'To' => $this->normalize_number($p_mobile),
                    'Body' => $p_message
                ]);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'message_sid' => $response->json()['sid'],
                ];
            } else {
                return [
                    'status' => false,
                    'error' => $response->json(),
                ];
            }
        } catch (\Exception $e) {
            throw new EMessageException('Error Sending SMS => ' . $e->getMessage());
        }
    }

    /**
     * @throws EMessageException
     */
    private function normalize_number($p_number): string
    {

        // Remove all non-digit characters
        $digits = preg_replace('/[^0-9]/', '', $p_number);

        // Convert 00 prefix to +
        if (str_starts_with($digits, '00')) {
            $digits = '+' . substr($digits, 2);
        }
        // Handle numbers without international prefix
        elseif (!str_starts_with($digits, '+')) {
            $digits = '+' . $digits;
        }

        if (!preg_match('/^\+[1-9]\d{6,14}$/', $digits)) {
            throw new EMessageException("Invalid phone number: {$p_number}");
        }

        return $digits;

    }

}
