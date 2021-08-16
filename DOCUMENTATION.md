# [WIP] Documentation (version 0.1)

## Table of Contents

1. [Invoices](#invoices)
    1. Creating simple invoice
    2. Using the constructor
    3. Sending invoice to Fakturownia
2. [Positions](#positions)
    1. Creating a position
    2. Specifying price - net or gross
    3. Adding position to an invoice
3. ~~InvoiceKind~~ *(coming soon)*
4. ~~PaymentType~~ *(coming soon)*
5. ~~Fakturownia~~ *(coming soon)*

---

## Invoices

This topic will show how to create invoices and what you can modify using helper class `FakturowniaInvoice`.

### Creating simple invoice

Here's an example for basic usage of creating a simple VAT kind invoice, specifying seller and buyer name and adding a single product into it:

```php
$invoice = new FakturowniaInvoice();

$invoice->seller['name'] = "Seller name";
$invoice->buyer['name'] = "Buyer name";

$product = new FakturowniaPosition("Product ABC", 1, 10.00);
$invoice->addPosition($product);
```

### Using the constructor

Normally Fakturownia API automatically generates a number for your new invoice, but if you wish to specify the number, kind of invoice and the language, you pass them as optional parameters in the invoice constructor:

```php
$invoice = new FakturowniaInvoice(FakturowniaInvoiceKind::PROFORMA, "FK 123/123/123", "en");
```

Or you can just set them by using invoice object variables:

```php
$invoice = new FakturowniaInvoice();
$invoice->kind = FakturowniaInvoiceKind::PROFORMA;
$invoice->number = "FK 123/123/123";
$invoice->language = "en";
```

### Sending invoice to Fakturownia

To create the invoice in Fakturownia.pl service you need to call static function `createInvoice` using `Fakturownia` static helper class (remember to have at one position in your invoice object!):

```php
$invoice = new FakturowniaInvoice();

...

Fakturownia::createInvoice($invoice);
```

---

## Positions

### Creating a position

Every invoice requires minimum one position added to the invoice. You can create position using helper class called `FakturowniaPosition`. Here's an example of creating a simple product:

```php
$name = "Product ABC";
$quantity = 1;
$price = 10.00;
$product = new FakturowniaPosition($name, $quantity, $price);
```

### Specifying price - net or gross

By default the price you specify for the position is set to gross price. If you wish to specify net price then you can use one of optional parameters of `FakturowniaPosition` constructor:

```php
// This is position with gross price
$product = new FakturowniaPosition("Product A", 1, 10.00);

// This is position with net price
$product = new FakturowniaPosition("Product B", 1, 12.30, false);

```

Or you can set variable `$isNetto` of the position object:

```php
$product = new FakturowniaPosition("Product ABC", 1, 12.30);
$product->isNetto = false;
```

### Adding position to an invoice

To add position object to the invoice object you can use command `addPosition()` on your invoice object:

```php
$invoice = new FakturowniaInvoice();
$product = new FakturowniaPosition("Product ABC", 1, 10.00);

$invoice->addPosition($product);
```
