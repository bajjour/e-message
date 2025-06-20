<?php

namespace EMessage\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{

    private string $access_token;
    private string $app_id;
    private string $app_secret;
    private string $phone_number_id;

    public function __construct(string $access_token, string $app_id, string $app_secret, string $phone_number_id)
    {
        $this->access_token = $access_token;
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->phone_number_id = $phone_number_id;
    }

    public function send_template($p_mobile, $p_template_name, $p_components, $p_lang = 'en_US'): array
    {

        try {
            $res = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ])->post('https://graph.facebook.com/v22.0/' . $this->phone_number_id . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $p_mobile,
                'type' => 'template',
                'template' => [
                    'name' => $p_template_name,
                    'language' => [
                        'code' => $p_lang
                    ],
                    'components' => $p_components,
                ]
            ]);

            if ($res->successful()) {
                $responseData = $res->json();
                if (isset($responseData['messages']) && !empty($responseData['messages'][0]['id'])) {
                    return [
                        'status' => true,
                        'response' => $res->json(),
                    ];
                }
            }

            return [
                'status' => false,
                'response' => $res->json(),
            ];

        } catch (\Exception $ex) {
        }

        return [
            'status' => false,
            'response' => 'unknown error',
        ];

    }

    public function refresh_token($p_short_token): array
    {
        $res = Http::get('https://graph.facebook.com/v22.0/oauth/access_token', [
            'grant_type' => 'fb_exchange_token',
            'client_id' => $this->app_id,
            'client_secret' => $this->app_secret,
            'fb_exchange_token' => $p_short_token,
        ]);

        if ($res->successful()) {
            return [
                'status' => true,
                'new_token' => $res->json('access_token'),
                'expires_in' => $res->json('expires_in'),
            ];
        }

        return [
            'status' => false,
            'response' => $res->json(),
        ];
    }
}