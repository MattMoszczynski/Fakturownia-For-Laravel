<?php

namespace MattM\FFL;

use MattM\FFL\FakturowniaDataInterface;

class FakturowniaPosition implements FakturowniaDataInterface
{
    private $id = null;
    public $name = "";
    public $code = "";
    public $description = "";

    public $quantity = 0;
    public $quantityUnit = null;

    public $tax = 0;
    public $price = 0.0;
    public $isNetto = false;

    function __construct($name, $quantity, $price, $isNetto = false, $tax = 23)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->isNetto = $isNetto;
        $this->tax = $tax;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getNetPrice()
    {
        return $this->isNetto ? $this->price : $this->price * 100.0 / (100.0 + $this->tax);
    }

    public function getGrossPrice()
    {
        return $this->isNetto ? $this->price + ($this->price * $this->tax / 100.0) : $this->price;
    }

    public static function createFromJson($json)
    {
        $position = new FakturowniaPosition($json['name'], $json['quantity'], $json['total_price_gross'], false, $json['tax']);
        $position->id = $json['id'];
        $position->code = $json['code'];
        $position->description = $json['description'];

        $position->quantityUnit = $json['quantity_unit'];

        return $position;
    }

    public function toArray()
    {
        $data = array(
            'name' => $this->name,
            'code' => $this->code,
            'quantity' => $this->quantity,
            'quantity_unit' => $this->quantityUnit,
            'tax' => $this->tax
        );

        if (isset($this->description) && !empty($this->description)) {
            $data['description'] = $this->description;
        }

        $data['total_price_gross'] = $this->getGrossPrice();

        return $data;
    }
}
