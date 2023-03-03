<?php

namespace MattM\FFL;

use Illuminate\Support\Facades\Http;
use MattM\FFL\FakturowniaInvoice;
use MattM\FFL\Helpers\FakturowniaInvoiceKind;

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

    public static function getInvoice(int $id, string $format = 'json')
    {
        return Http::get(self::buildUrl() . "invoices/" . $id . "." . $format . "?api_token=" . self::$token);
    }

    public static function changeInvoiceStatus(int $id, string $status)
    {
        return Http::post(self::buildUrl() . "invoices/" . $id . "/change_status.json?api_token=" . self::$token . "&status=" . $status);
    }

    public static function printInvoiceRaw(int $id)
    {
        return Http::get(self::buildUrl() . "invoices/" . $id . ".pdf?api_token=" . self::$token);
    }

    public static function printInvoice(int $id, string $name)
    {
        $content = self::printInvoiceRaw($id);

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $name . '.pdf', [ 'Content-Type' => 'application/pdf' ]);
    }

    public static function updateInvoice(int $id, array $attributes)
    {
        $data = array();
        $data['api_token'] = self::$token;
        $data['invoice'] = $attributes;

        return Http::accept('application/json')->put(self::buildUrl() . "invoices/" . $id . ".json", $data);
    }

    public static function deleteInvoice(int $id)
    {
        return Http::delete(self::buildUrl() . "invoices/" . $id . ".json?api_token=" . self::$token);
    }

    public static function copyInvoice(int $id, array $attributes=[])
    {
        $data = array();
        $data['api_token'] = self::$token;
        $data['invoice'] = [
            'copy_invoice_from'=>$id,
            ...$attributes
        ];

        return Http::accept('application/json')->post(self::buildUrl() . "invoices.json", $data);
    }

    public static function copyProformaToInvoice(int $id, array $attributes=[])
    {
        $data = array();
        $data['api_token'] = self::$token;
        $data['invoice'] = [
            'copy_invoice_from'=>$id,
            'kind'=>FakturowniaInvoiceKind::INVOICE_VAT,
            ...$attributes
        ];

        return Http::accept('application/json')->post(self::buildUrl() . "invoices.json", $data);
    }
}

Fakturownia::__constructStatic();
