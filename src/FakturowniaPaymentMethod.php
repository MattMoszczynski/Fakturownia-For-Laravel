<?php

namespace MattM\FFL;

class FakturowniaPaymentMethod
{
    /**
     * Metoda płatności - przelew
     */
    const TRANSFER = "transfer";

    /**
     * Metoda płatności - karta płatnicza
     */
    const CARD = "card";

    /**
     * Metoda płatności - gotówka
     */
    const CASH = "cash";

    /**
     * Metoda płatności - barter
     */
    const BARTER = "barter";

    /**
     * Metoda płatności - czek
     */
    const CHEQUE = "cheque";

    /**
     * Metoda płatności - weksel
     */
    const BILL_OF_EXCHANGE = "bill_of_exchange";

    /**
     * Metoda płatności - opłata za pobraniem
     */
    const CASH_ON_DELIVERY = "cash_on_delivery";

    /**
     * Metoda płatności - kompensata
     */
    const COMPENSATION = "compensation";

    /**
     * Metoda płatności - akredytywa
     */
    const LETTER_OF_CREDIT = "letter_of_credit";
    
    /**
     * Metoda płatności - PayU
     */
    const PAYU = "payu";

    /**
     * Metoda płatności - PayPal
     */
    const PAYPAL = "paypal";

     /**
     * Metoda płatności - nie wyświetlaj
     */
    const HIDE = "off";
}
