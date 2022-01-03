<?php

namespace MattM\FFL\Helpers;

class FakturowniaInvoiceStatus
{
    /**
     * Status faktury - wystawiona
     */
    const ISSUED = "issued";

    /**
     * Status faktury - wysłana
     */
    const SENT = "sent";

    /**
     * Status faktury - opłacona
     */
    const PAID = "paid";

    /**
     * Status faktury - częściowo opłacona
     */
    const PARTIAL = "partial";

    /**
     * Status faktury - odrzucona
     */
    const REJECTED = "rejected";
}
