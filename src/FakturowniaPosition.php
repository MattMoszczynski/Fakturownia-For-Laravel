<?php

namespace MattM\FFL;

use MattM\FFL\FakturowniaDataObject;

class FakturowniaPosition extends FakturowniaDataObject
{
    private ?int $id = null;
    public string $name = "";
    public string $code = "";
    public string $description = "";

    public int $quantity = 0;
    public ?string $quantityUnit = null;

    public int $tax = 0;
    public float $price = 0.0;
    public bool $isNetto = false;

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

        if (isset($json['code']) && !empty($json['code'])) {
            $position->code = $json['code'];
        }

        $position->description = $json['description'];
        $position->quantityUnit = $json['quantity_unit'];

        // ----------[ DATA PROCESSING END ]----------

        return $position;
    }

    public function toArray($includeEmptyFields = true)
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

        // ----------[ DATA PROCESSING END ]----------

        if ($includeEmptyFields === false) {
            $data = $this->removeEmptyFields($data);
        }

        return $data;
    }
}
