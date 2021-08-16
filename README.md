# Fakturownia For Laravel

[![Latest Version](https://img.shields.io/github/release/MattMoszczynski/Fakturownia-For-Laravel.svg?include_prereleases&label=packagist&style=flat-square)](https://packagist.org/packages/mattm/fakturownia-for-laravel)
[![Last Commit](https://img.shields.io/github/last-commit/MattMoszczynski/Fakturownia-For-Laravel.svg?style=flat-square)](https://github.com/MattMoszczynski/Fakturownia-For-Laravel/commit/main)
[![License](https://img.shields.io/github/license/MattMoszczynski/Fakturownia-For-Laravel.svg?style=flat-square)](https://github.com/MattMoszczynski/Fakturownia-For-Laravel/blob/main/LICENSE)

A Laravel package for easy integration with Fakturownia (InvoiceOcean) API ([fakturownia.pl](https://fakturownia.pl), [invoiceocean.com](https://invoiceocean.com)). The package contains custom helper classes which allows easy management with invoices. 

## Features of the package

- retrieving invoices
- creating new invoice
- ~~updating an invoice~~ *(coming soon)*
- ~~deleting an invoice~~ *(coming soon)*

## Installation

The recommended way to install the package is by using
[Composer](https://getcomposer.org/).

```bash
composer require mattm/fakturownia-for-laravel
```

After installation make sure to specify in your Laravel project these envelop keys:

```env
FAKTUROWNIA_DOMAIN=your_domain_prefix
FAKTUROWNIA_TOKEN=your_generated_token
```

## Documentation

Documentation for this package can be find in a file [DOCUMENTATION.md](https://github.com/MattMoszczynski/Fakturownia-For-Laravel/blob/main/DOCUMENTATION.md).
