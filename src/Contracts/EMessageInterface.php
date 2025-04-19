<?php
namespace EMessage\Contracts;

interface EMessageInterface
{
    public function send_sms_use_phone(string $p_mobile, string $p_message, string $p_send_num = null): array;

    public function send_sms_use_service(string $p_mobile, string $p_message, string $p_service = null): array;
    public function send_whatsapp(string $p_mobile, string $p_message, string $p_send_num = null): array;

}
