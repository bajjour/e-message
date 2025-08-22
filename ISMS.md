# ISMS Integration

[← Back to Main README](./README.md)

`Send ISMS Message`

if you need to integrate with isms api, Update your .env file with your isms username and password:

```bash
ISMS_USERNAME="your-isms-username"
ISMS_PASSWORD="your-isms-password"
```

## ISMS API Usage
`Initialize the Service`

You can initialize ISMS Service in your controller:

```php
use EMessage\Services\ISMSService;

protected ISMSService $i_service;

public function __construct(ISMSService $i_service)
{
    $this->i_service = $i_service;
}
```

you can check your sms balance using the following function.

```php
$res = $this->i_service->check_balance();
```

the response for check_balance() as the following

success
```json
{
  "status": true,
  "result": "your-sms-balance",
  "message": "your-sms-balance"
}
```

fail
```json
{
  "status": false,
  "result": "Negative Number that represent the error",
  "message": "Error Message"
}
```

you can check your sms subscription expire date using the following function.

```php
$res = $this->i_service->check_expire_date();
```

the response for check_expire_date() as the following

success
```json
{
  "status": true,
  "result": "your-expire-date",
  "message": "your-expire-date"
}
```

fail
```json
{
"status": false,
"result": "Negative Number that represent the error",
"message": "Error Message"
}
```

you can send sms using the following function.

```php
//////for single number
$mobile = '+601111111084';
$msg = 'your-sms-text';
$res = $this->i_service->send_sms($mobile, $msg);

//////for bulk
$mobiles = '+60xxxxxxxxx1,+60xxxxxxxxx2,.....';
$msg = 'Welcome';
$res = $this->i_service->send_bulk_sms($mobiles, $msg);

```

the response for sending message as the following

success
```json
{
  "status": true,
  "result": "2000 = SUCCESS:SMS ID or EMPTY/BLANK",
  "message": "isms response"
}
```

fail
```json
{
"status": false,
"result": "Negative Number that represent the error",
"message": "Error Message"
}
```

For more details about the ISMS API and error codes, refer to the official documentation:

[ISMS API](https://www.isms.com.my/sms_api.php)
