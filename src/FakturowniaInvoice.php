<?php

namespace MattM\FFL;

use MattM\FFL\FakturowniaPosition;
use MattM\FFL\FakturowniaInvoiceKind;
use MattM\FFL\FakturowniaPaymentMethod;

class FakturowniaInvoice
{
    public $kind = null;
    public $number = "";
    public $description = "";
    public $paymentType = "";
    public $language = "";

    public $issueDate = null;
    public $sellDate = null;
    public $paymentDate = null;

    public $seller = array();
    public $buyer = array();
    public $recipient = array();
    public $isBuyerCompany = true;

    public $skonto = null;

    public $positions = array();

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
            'nip' => null,
            'street' => "",
            'post_code' => "",
            'city' => "",
            'country' => "",
            'phone' => ""
        );
        $this->buyer = array(
            'name' => "",
            'nip' => null,
            'street' => "",
            'post_code' => "",
            'city' => "",
            'country' => "",
            'phone' => ""
        );
        $this->recipient = null;
        $this->isBuyerCompany = true;

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
        $when = mktime(0, 0, 0, date("m")  , date("d") + $days, date("Y"));

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

    public function toArray()
    {
        $data = array(
            'kind' => $this->kind,
            'number' => $this->number,
            'description' => $this->description,
            'issue_date' => $this->issueDate,
            'sell_date' => $this->sellDate,
            'lang' => $this->language,
            'seller_name' => $this->seller['name'],
            'seller_tax_no' => $this->seller['nip'],
            'seller_street' => $this->seller['street'],
            'seller_post_code' => $this->seller['post_code'],
            'seller_city' => $this->seller['city'],
            'seller_country' => $this->seller['country'],
            'seller_phone' => $this->seller['phone'],
            'buyer_name' => $this->buyer['name'],
            'buyer_tax_no' => $this->buyer['nip'],
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

        return $data;
    }
}
