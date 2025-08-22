# Whatsapp Integration

[← Back to Main README](./README.md)

`Send Whatsapp Message`

if you need to integrate with whatsapp api, Update your .env file with your meta account settings:

```bash
WHATSAPP_PHONE_NUMBER_ID="your-whatsapp-phone-number-id"
WHATSAPP_ACCESS_TOKEN="your-whatsapp-access-token"
WHATSAPP_APP_ID="app-id" #optional, required only with refresh token
WHATSAPP_APP_SECRET="app-secret" #optional, required only with refresh token
```

## Whatsapp API Usage
`Initialize the Service`

You can initialize WhatsApp Service in your controller:

```php
use EMessage\Services\WhatsAppService;

protected WhatsAppService $w_service;

public function __construct(WhatsAppService $w_service)
{
    $this->w_service = $w_service;
}
```

`Send Whatsapp Template`

you can send whatsapp template by calling send_template() function. like the following

```php
$otp = 'random-digits';

$template_name = 'otp';
$mobile = '970xxxxxxxxx';
$lang_code = 'en_US';

$components = [
    [
        'type' => 'body',
        'parameters' => [
            [
                'type' => 'text',
                'text' => $otp
            ]
        ]
    ],
    [
        'type' => 'button',
        'sub_type' => 'url',
        'index' => '0',
        'parameters' => [
            [
                'type' => 'text',
                'text' => $otp
            ]
        ]
    ]
];

$res = $this->w_service->send_template($mobile, $template_name, $components, $lang_code);
```

Success Response
```json
{
  "status":true,
  "response":{
    "messaging_product":"whatsapp",
    "contacts":[{
      "input":"970xxxxxxxxx",
      "wa_id":"970xxxxxxxxx"
    }],
    "messages":[{
      "id":"sent-message-id",
      "message_status":"accepted"
    }]
  }
}
```

Fail Response
```json
{
  "status":false,
  "response":"Error Details"
}
```

`Refresh Whatsapp Token`

Sometimes Meta account provide you with short time token, using the
following function, you can generate long time token that valid for
60 days.

Don't forget to set **WHATSAPP_APP_ID, WHATSAPP_APP_SECRET** in env before calling refresh_token.


```php
$short_time_token = 'token....';

$res = $this->w_service->refresh_token($short_time_token);
```

Success Response
```json
{
  "status":true,
  "new_token": "new-60-days-token",
  "expires_in": "expire-day"
}
```

Fail Response
```json
{
  "status":false,
  "response":"Error Details"
}
```