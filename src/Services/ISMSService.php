<?php
namespace EMessage\Services;

use EMessage\Contracts\ISMSInterface;
use EMessage\Exceptions\ISMSException;
use Illuminate\Support\Facades\Http;

class ISMSService implements ISMSInterface
{
    private string $username;
    private string $password;
    private string $base_uri;
    protected $client;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->base_uri = 'https://www.isms.com.my';

        $this->client = Http::baseUrl($this->base_uri)
            ->timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]);
    }

    /**
     * Send SMS
     */
    public function send_sms(string $dest_no, string $msg): array
    {
        if (!$this->validate_my_mobile($dest_no)) {
            return [
                'status' => false,
                'result' => -2,
                'message' => 'invalid mobile number'
            ];
        }

        $response = $this->client->asForm()->post('/isms_send_all_id.php', [
            'un' => $this->username,
            'pwd' => $this->password,
            'dstno' => $dest_no,
            'msg' => $msg,
            'type' => 1,
            'agreedterm' => 'YES',
        ]);

        return $this->render_response($response);
    }

    /**
     * Send Group SMS
     */
    public function send_bulk_sms(string $dest_no, string $msg): array
    {
        if (!$this->validate_my_mobile($dest_no)) {
            return [
                'status' => false,
                'result' => -2,
                'message' => 'invalid mobile number'
            ];
        }

        $response = $this->client->asForm()->post('/isms_send.php', [
            'un' => $this->username,
            'pwd' => $this->password,
            'dstno' => $dest_no,
            'msg' => $msg,
            'type' => 1,
            'agreedterm' => 'YES',
        ]);

        return $this->render_response($response);
    }

    /**
     * Check Account Balance
     */
    public function check_balance(): array
    {
        $response = $this->client->asForm()->post('/isms_balance.php', [
            'un' => $this->username,
            'pwd' => $this->password,
        ]);

        return $this->render_response($response);
    }

    /**
     * Check Accout Expire Date
     */
    public function check_expire_date(): array
    {
        $response = $this->client->asForm()->post('/isms_expiry_date.php', [
            'un' => $this->username,
            'pwd' => $this->password,
        ]);

        return $this->render_response($response);
    }

    private function render_response($response): array
    {
        if ($response->successful()) {
            $str_arr = explode("=", $response->body());

            if (count($str_arr) > 0) {
                return [
                    'status' => !(is_numeric($str_arr[0]) && $str_arr[0] < 0),
                    'result' => $str_arr[0],
                    'message' => $response->body()
                ];
            }
        }

        return [
            'status' => false,
            'result' => -1,
            'message' => $response->body()
        ];
    }

    private function validate_my_mobile($mobile): bool
    {
        if (strlen($mobile) < 4) {
            return false;
        }

        $numbers = array_map('trim', explode(',', $mobile));

        foreach ($numbers as $number) {
            $cleaned = preg_replace('/[^\d+]/', '', $number);
            $pattern = '/^(\+?60|0)(1[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])([0-9]{7,8})$/';

            if (preg_match($pattern, $cleaned) !== 1) {
                return false;
            }
        }

        return true;
    }

}
