# [WIP] Documentation (version 0.1)

## Table of Contents

1. [Invoices](#invoices)
    1. Creating simple invoice
    2. Using the constructor
2. [Positions](#positions)
    1. Creating a position
    2. Specifying price - net or gross
    3. Adding position to an invoice
3. [InvoiceKind](#invoicekind)
4. [PaymentMethod](#paymentmethod)
5. [Fakturownia](#fakturownia)
    1. Retreiving an invoice from Fakturownia
    2. Sending invoice to Fakturownia
    3. Updating specific invoice in Fakturownia
    4. Deleting target invoice from Fakturownia database

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

---

## Positions

This section describes all functionality of `FakturowniaPosition` class, showing it's main methods for an easy management of the positions objects.

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

---

## InvoiceKind

There's a `FakturowniaInvoiceKind` that contains constants for choosing one of existing kind of invoice for Fakturownia service.

```php
// Set the invoice kind to proforma
$invoice->kind = FakturowniaInvoiceKind::PROFORMA;
```

---

## PaymentMethod

Class `FakturowniaPaymentMethod` has constants for choosing one of existing and acceptable payment methods for the Fakturownia invoices.

```php
// Set the payment method to cash option
$invoice->paymentType = FakturowniaPaymentMethod::CASH;
```

---

## Fakturownia

`Fakturownia` is a main helper class used to communicate with Fakturownia API servive. This class has been initialized in project using *singleton* command in Laravel.

### Retreiving an invoice from Fakturownia

To simply retrieve an existing invoice from Fakturownia service you can use static command `getInvoice` specifying an ID of the invoice as a first parameter of the function - see an example below:

```php
$response = Fakturownia::getInvoice(123456789);

var_dump($response);
```

### Sending invoice to Fakturownia

To create the invoice in Fakturownia service you need to call static function `createInvoice` using `Fakturownia` static helper class (remember to have at one position in your invoice object!):

```php
$invoice = new FakturowniaInvoice();

...

Fakturownia::createInvoice($invoice);
```

### Updating specific invoice in Fakturownia

```php
Fakturownia::updateInvoice(1234566789, array(
    'kind' => FakturowniaInvoiceKind::PROFORMA,
    'buyer_name' => 'John Wick'
    'buyer_company' => '0'
));
```

### Deleting target invoice from Fakturownia database

```php
Fakturownia::deleteInvoice(1234566789);
```

---
