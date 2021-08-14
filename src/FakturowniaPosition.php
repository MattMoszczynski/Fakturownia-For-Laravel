<?php

namespace MattM\FFL;

class FakturowniaPosition
{
    public $name = "";
    public $code = "";
    public $description = "";

    public $quantity = 0;
    public $quantityUnit = null;

    public $vat = 0;
    public $price = 0.0;
    public $isNetto = false;

    function __construct($name, $quantity, $price, $isNetto = false, $vat = 23) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->isNetto = $isNetto;
        $this->vat = $vat;
    }

    public function toArray()
    {
        $data = array(
            'name' => $this->name,
            'code' => $this->code,
            'quantity' => $this->quantity,
            'quantity_unit' => $this->quantityUnit,
            'tax' => $this->vat
        );

        if (isset($this->description) && !empty($this->description)) {
            $data['description'] = $this->description;
        }

        $data['total_price_gross'] = $this->isNetto ? $this->price + ($this->price * $this->vat / 100.0) : $this->price;

        return $data;
    }
}
