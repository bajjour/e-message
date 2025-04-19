<?php

return [
    'account_sid' => env('EMESSAGE_ACCOUNT_SID', ''),
    'auth_token' => env('EMESSAGE_AUTH_TOKEN', ''),
    'default_send_number' => env('EMESSAGE_DEFAULT_SEND_NUMBER', ''),//optional
    'default_service_sid' => env('EMESSAGE_DEFAULT_SEND_SERVICE', ''),//optional
    'default_whatsapp_send_number' => env('EMESSAGE_SEND_WHATSAPP_NUMBER', ''),//optional
];
