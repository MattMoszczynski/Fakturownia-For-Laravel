<?php

namespace MattM\FFL;

class FakturowniaInvoiceKind
{
    /**
     * Rodzaj faktury - faktura VAT
     */
    const INVOICE_VAT = "vat";

    /**
     * Rodzaj faktury - faktura Proforma
     */
    const INVOICE_PROFORMA = "proforma";

    /**
     * Rodzaj faktury - rachunek
     */
    const BILL = "bill";

    /**
     * Rodzaj faktury - paragon
     */
    const RECEIPT = "receipt";

    /**
     * Rodzaj faktury - faktura zaliczkowa
     */
    const INVOICE_ADVANCE = "advance";

    /**
     * Rodzaj faktury - faktura końcowa
     */
    const INVOICE_FINAL = "final";

    /**
     * Rodzaj faktury - faktura korekta
     */
    const INVOICE_CORRECTION = "correction";

    /**
     * Rodzaj faktury - inna faktura
     */
    const INVOICE_OTHER = "invoice_other";

    /**
     * Rodzaj faktury - faktura marża
     */
    const INVOICE_VAT_MARGIN = "vat_margin";

    /**
     * Rodzaj faktury - kasa przyjmie
     */
    const KP = "kp";

    /**
     * Rodzaj faktury - kasa wyda
     */
    const KW = "kw";

    /**
     * Rodzaj faktury - zamówienie wyda
     */
    const ESTIMATE = "estimate";

    /**
     * Rodzaj faktury - faktura MP
     */
    const INVOICE_VAT_MP = "vat_mp";

    /**
     * Rodzaj faktury - faktura RR
     */
    const INVOICE_VAT_RR = "vat_rr";

    /**
     * Rodzaj faktury - nota korygująca
     */
    const NOTE_CORRECTION = "correction_note";

    /**
     * Rodzaj faktury - nota księgowa
     */
    const NOTE_ACCOUNTING = "accounting_note";

    /**
     * Rodzaj faktury - własny dokument nieksięgowy
     */
    const CLIENT_ORDER = "client_order";

    /**
     * Rodzaj faktury - dowód wewnętrzny
     */
    const DW = "dw";

    /**
     * Rodzaj faktury - Wewnątrzwspólnotowe Nabycie Towarów
     */
    const WNT = "wnt";

    /**
     * Rodzaj faktury - Wewnątrzwspólnotowa Dostawa Towarów
     */
    const WDT = "wdt";

    /**
     * Rodzaj faktury - import usług
     */
    const IMPORT_SERVICE = "import_service";

    /**
     * Rodzaj faktury - import usług z UE
     */
    const IMPORT_SERVICE_EU = "import_service_eu";

    /**
     * Rodzaj faktury - import towarów - procedura uproszczona
     */
    const IMPORT_PRODUCTS = "import_products";

    /**
     * Rodzaj faktury - eksport towarów
     */
    const EXPORT_PRODUCTS = "export_products";
}
