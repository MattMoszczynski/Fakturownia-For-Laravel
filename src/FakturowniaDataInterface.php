<?php

namespace MattM\FFL;

interface FakturowniaDataInterface
{
    public function getID();

    public static function createFromJson($json);
    public function toArray();
}
