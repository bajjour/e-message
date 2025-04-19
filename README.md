# E-Message Laravel Package

This package provides a simple and easy-to-use interface to send SMS and Whatsapp to any phone using twillo in laravel applications.

---

## Installation

You can install the package via Composer:

```bash
composer require bajjour/emessage-pkg
```

## Configuration

After installing the package, publish the configuration file:

```bash
php .\artisan vendor:publish --provider="EMessage\EmessageServiceProvider" --tag="e-message-config"
```

Update your .env file with your Twillo account settings:

```bash
EMESSAGE_ACCOUNT_SID="your-twillo-account-sid"
EMESSAGE_AUTH_TOKEN="your-twillo-auth-token"
EMESSAGE_DEFAULT_SEND_NUMBER="your-send-number" #required when sending using phone number
EMESSAGE_DEFAULT_SEND_SERVICE="your-send-messaging-service-sid" #required when sending using service
EMESSAGE_SEND_WHATSAPP_NUMBER="your-whatsapp-sending-messaging" #required when sending using whatsapp
```

## Usage

`Initialize the Service`

You can initialize EMessage service in your controller:

```php
use EMessage\Services\EMessageService;

protected EMessageService $em_service;

public function __construct(EMessageService $em_service)
{
    $this->em_service = $em_service;
}
```

`Send SMS using Phone Number`

you can send sms using default send number that you entered in .env file.

```php
$receive_mobile = '+970XXXXXXXXX'; //receive mobile with international code
$message = 'your message to your user';
$res = $this->em_service->send_sms_use_phone($receive_mobile, $message);
```

if you have multiple send numbers you can also pass send number to send_sms_use_phone function
```php
$receive_mobile = '+970XXXXXXXXX'; //receive mobile with international code
$message = 'your message to your user';
$send_number = 'your_send_number';
$res = $this->em_service->send_sms_use_phone($receive_mobile, $message, $send_number);
```

Response
```json
{
  "status":true,
  "message_sid":"message_sid"
}
```

`Send SMS using Messaging Service`

you can send sms using default send service that you entered in .env file.

```php
$receive_mobile = '+970XXXXXXXXX'; //receive mobile with international code
$message = 'your message to your user';
$res = $this->em_service->send_sms_use_service($receive_mobile, $message);
```

if you have multiple "Messaging Services" you can also pass "send_service" to send_sms_use_service function
```php
$receive_mobile = '+970XXXXXXXXX'; //receive mobile with international code
$message = 'your message to your user';
$send_service = 'your_messaging_service_sid';
$res = $this->em_service->send_sms_use_service($receive_mobile, $message, $send_service);
```

Response
```json
{
  "status":true,
  "message_sid":"message_sid"
}
```

when sending sms fails you will receive another response like the following
```json
{
  "status":false,
  "error":{
    "code":21705,
    "message":"The Messaging Service Sid xxx is invalid.",
    "more_info":"https:\/\/www.twilio.com\/docs\/errors\/21705",
    "status":400
  }
}
```


`Send Whatsapp Message`

you can send whatsapp using the following function.

```php
$receive_mobile = '+970XXXXXXXXX'; //receive whatsapp number
$message = 'your message to your user';
$res = $this->em_service->send_whatsapp($receive_mobile, $message);
```

the response for sending whatsapp as the following

success
```json
{
  "status": true,
  "response": {
    "account_sid": "your-sid",
    "api_version": "2010-04-01",
    "body": "sent-message",
    "date_created": "Sat, 19 Apr 2025 12:17:30 +0000",
    "date_sent": null,
    "date_updated": "Sat, 19 Apr 2025 12:17:30 +0000",
    "direction": "outbound-api",
    "error_code": null,
    "error_message": null,
    "from": "whatsapp:your-whatsapp-send-number",
    "messaging_service_sid": null,
    "num_media": "0",
    "num_segments": "1",
    "price": null,
    "price_unit": null,
    "sid": "sid",
    "status": "queued",
    "subresource_uris": {
      "media": "media json"
    },
    "to": "whatsapp:receive-mobile",
    "uri": "json-path"
  }
}
```

fail
```json
{
  "status":false,
  "response_status":400,
  "response_body":{
    "code":63007,
    "message":"Twilio could not find a Channel with the specified From address",
    "more_info":"https:\/\/www.twilio.com\/docs\/errors\/63007",
    "status":400
  }
}
```

## License

[MIT](https://choosealicense.com/licenses/mit/)