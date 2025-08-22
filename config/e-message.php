<?php

return [
    //used with twillo integration
    'account_sid' => env('EMESSAGE_ACCOUNT_SID', ''),
    'auth_token' => env('EMESSAGE_AUTH_TOKEN', ''),
    'default_send_number' => env('EMESSAGE_DEFAULT_SEND_NUMBER', ''),//optional
    'default_service_sid' => env('EMESSAGE_DEFAULT_SEND_SERVICE', ''),//optional
    'default_whatsapp_send_number' => env('EMESSAGE_SEND_WHATSAPP_NUMBER', ''),//optional

    //used with whatsapp integration
    'whatsapp_phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID', ''),
    'whatsapp_access_token' => env('WHATSAPP_ACCESS_TOKEN', ''),
    'whatsapp_app_id' => env('WHATSAPP_APP_ID', ''), //optional, required only with refresh token
    'whatsapp_app_secret' => env('WHATSAPP_APP_SECRET', ''), //optional, required only with refresh token

    //used with ISMS integration
    'isms_username' => env('ISMS_USERNAME', ''),
    'isms_password' => env('ISMS_PASSWORD', ''),
];
