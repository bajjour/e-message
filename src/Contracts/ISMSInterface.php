<?php
namespace EMessage\Contracts;

interface ISMSInterface
{
    public function send_sms(string $dest_no, string $msg): array;

    public function send_bulk_sms(string $dest_no, string $msg): array;

    public function check_balance(): array;

    public function check_expire_date(): array;

}
