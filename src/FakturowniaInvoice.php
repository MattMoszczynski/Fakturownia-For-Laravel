<?php

namespace MattM\FFL;

use MattM\FFL\FakturowniaDataObject;
use MattM\FFL\FakturowniaPosition;
use MattM\FFL\Helpers\FakturowniaInvoiceKind;
use MattM\FFL\Helpers\FakturowniaPaymentMethod;

class FakturowniaInvoice extends FakturowniaDataObject
{
    private ?int $id = null;
    public string $kind = "";
    public string $number = "";
    public ?string $pattern = null;
    public ?int $departmentID = null;
    public string $description = "";
    public string $paymentType = "";
    public string $language = "";

    public ?string $issueDate = null;
    public ?string $sellDate = null;
    public ?string $paymentDate = null;

    public array $seller = array();
    public array $buyer = array();
    public ?array $recipient = null;
    public bool $isBuyerCompany = true;

    public ?array $skonto = null;

    public array $positions = array();

    public function __construct($kind = FakturowniaInvoiceKind::INVOICE_VAT, $number = "", $language = "pl")
    {
        $this->number = $number;
        $this->kind = $kind;
        $this->paymentType = FakturowniaPaymentMethod::TRANSFER;

        $this->issueDate = date("Y-m-d");
        $this->sellDate = date("Y-m-d");
        $this->paymentDate = null;

        $this->language = $language;

        $this->seller = array(
            'name' => "",
            'tax_number' => null,
            'street' => "",
            'post_code' => "",
            'city' => "",
            'country' => "",
            'phone' => ""
        );
        $this->buyer = array(
            'name' => "",
            'tax_number' => null,
            'street' => "",
            'post_code' => "",
            'city' => "",
            'country' => "",
            'phone' => ""
        );
        $this->recipient = null;

        $this->positions = array();
    }

    public function setPaymentDeadline(int $days)
    {
        $this->paymentDate = $days;
    }

    public function setPaymentDeadlineDate(int $year, int $month, int $day)
    {
        $this->paymentDate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
    }

    public function setSkonto(int $discount, int $days)
    {
        $when = mktime(0, 0, 0, date("m"), date("d") + $days, date("Y"));

        $this->skonto = array(
            'discount' => $discount,
            'date' => date("Y-m-d", $when)
        );
    }

    public function setSkontoDate(int $discount, int $year, int $month, int $day)
    {
        $this->skonto = array(
            'discount' => $discount,
            'date' => date("Y-m-d", mktime(0, 0, 0, $month, $day, $year))
        );
    }

    public function bilingualInvoice(string $primatyLanguage, string $secondaryLanguage)
    {
        $this->language = $primatyLanguage . '/' . $secondaryLanguage;
    }

    public function addPosition(FakturowniaPosition $newPosition)
    {
        array_push($this->positions, $newPosition);
    }

    public function getID()
    {
        return $this->id;
    }

    public static function createFromJson($json)
    {
        $invoice = new FakturowniaInvoice($json['kind'], $json['number'], $json['lang']);
        $invoice->id = $json['id'];
        $invoice->paymentType = $json['payment_type'];
        $invoice->pattern = $json['pattern'];
        $invoice->departmentID = $json['department_id'];

        $invoice->issueDate = $json['issue_date'];
        $invoice->sellDate = $json['sell_date'];

        if ($json['payment_to_kind'] != "other_date") {
            $invoice->paymentDate = $json['payment_to_kind'];
        } else {
            $invoice->paymentDate = $json['payment_to'];
        }

        $invoice->seller = array(
            'name' => $json['seller_name'],
            'tax_number' => $json['seller_tax_no'],
            'street' => $json['seller_street'],
            'post_code' => $json['seller_post_code'],
            'city' => $json['seller_city'],
            'country' => $json['seller_country'],
            'phone' => $json['seller_phone']
        );
        $invoice->buyer = array(
            'name' => $json['buyer_name'],
            'tax_number' => $json['buyer_tax_no'],
            'street' => $json['buyer_street'],
            'post_code' => $json['buyer_post_code'],
            'city' => $json['buyer_city'],
            'country' => $json['buyer_country'],
            'phone' => $json['buyer_phone']
        );

        $invoice->isBuyerCompany = ($json['buyer_company'] > 0 ? true : false);

        if (isset($json['recipient_name']) && !empty($json['recipient_name'])) {
            $invoice->recipient = array(
                'name' => $json['recipient_name'],
                'street' => $json['recipient_street'],
                'post_code' => $json['recipient_post_code'],
                'city' => $json['recipient_city'],
                'country' => $json['recipient_country'],
                'phone' => $json['recipient_phone']
            );
        }

        if (isset($json['skonto_active']) && $json['skonto_active'] > 0) {
            $invoice->skonto = array();
            $invoice->skonto['discount'] = $json['skonto_discount_value'];
            $invoice->skonto['date'] = $json['skonto_discount_date'];
        }

        $invoice->positions = array();

        foreach ($json['positions'] as $jsonPosition) {
            $position = FakturowniaPosition::createFromJson($jsonPosition);
            $invoice->addPosition($position);
        }

        return $invoice;
    }

    public function toArray($includeEmptyFields = true)
    {
        $data = array(
            'kind' => $this->kind,
            'number' => $this->number,
            'pattern' => $this->pattern,
            'department_id' => $this->departmentID,
            'description' => $this->description,
            'issue_date' => $this->issueDate,
            'sell_date' => $this->sellDate,
            'lang' => $this->language,
            'seller_name' => $this->seller['name'],
            'seller_tax_no' => $this->seller['tax_number'],
            'seller_street' => $this->seller['street'],
            'seller_post_code' => $this->seller['post_code'],
            'seller_city' => $this->seller['city'],
            'seller_country' => $this->seller['country'],
            'seller_phone' => $this->seller['phone'],
            'buyer_name' => $this->buyer['name'],
            'buyer_tax_no' => $this->buyer['tax_number'],
            'buyer_street' => $this->buyer['street'],
            'buyer_post_code' => $this->buyer['post_code'],
            'buyer_city' => $this->buyer['city'],
            'buyer_country' => $this->buyer['country'],
            'buyer_phone' => $this->buyer['phone'],
            'buyer_company' => ($this->isBuyerCompany ? "1" : "0")
        );

        if (isset($this->recipient) && count($this->recipient) > 0) {
            $recipient = array(
                'recipient_name' => $this->recipient['name'],
                'recipient_street' => $this->recipient['street'],
                'recipient_post_code' => $this->recipient['post_code'],
                'recipient_city' => $this->recipient['city'],
                'recipient_country' => $this->recipient['country'],
                'recipient_phone' => $this->recipient['phone']
            );

            $data = array_merge($data, $recipient);
        }

        if (isset($this->paymentDate) && !empty($this->paymentDate)) {
            if (is_numeric($this->paymentDate)) {
                $data['payment_to_kind'] = $this->paymentDate;
            } else {
                $data['payment_to_kind'] = "other_date";
                $data['payment_to'] = $this->paymentDate;
            }
        }

        if (isset($this->skonto)) {
            $data['skonto_active'] = "1";
            $data['skonto_discount_value'] = $this->skonto['discount'];
            $data['skonto_discount_date'] = $this->skonto['date'];
        }

        $data['positions'] = array();

        foreach ($this->positions as $fakturowniaPosition) {
            array_push($data['positions'], $fakturowniaPosition->toArray());
        }

        if ($includeEmptyFields === false) {
            $data = $this->removeEmptyFields($data);
        }

        return $data;
    }
}
