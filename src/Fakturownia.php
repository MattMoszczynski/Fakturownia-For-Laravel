<?php

namespace MattM\FFL;

use Illuminate\Support\Facades\Http;
use MattM\FFL\FakturowniaInvoice;
use MattM\FFL\FakturowniaPosition;

class Fakturownia
{
    private static $token = '';
    private static $domain = '';

    public static function __constructStatic()
    {
        self::$token = config('fakturownia.token');
        self::$domain = config('fakturownia.domain');
    }

    private static function buildUrl()
    {
        return "https://" . self::$domain . ".fakturownia.pl/";
    }

    public static function createInvoice(FakturowniaInvoice $invoice)
    {
        $data = array();
        $data['api_token'] = self::$token;
        $data['invoice'] = $invoice->toArray();

        return Http::accept('application/json')->post(self::buildUrl() . "invoices.json", $data);
    }

    public static function getInvoice(int $id)
    {
        return Http::get(self::buildUrl() . "invoices/" . $id . ".json?api_token=" . self::$token);
    }
}

Fakturownia::__constructStatic();
