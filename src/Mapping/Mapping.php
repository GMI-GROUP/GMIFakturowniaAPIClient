<?php

namespace Gmigroup\Clients\Fakturownia\Mapping;

class Mapping
{
    private const createInvoice = 'invoices.json';
    private const getInvoices = 'invoices.json';
    private const getInvoice = 'invoices/[ID].json';
    private const deleteInvoice = 'invoices/[ID].json';

    public const ALL_METHODS = [
        'createInvoice' => self::createInvoice,
        'getInvoices' => self::getInvoices,
        'getInvoice' => self::getInvoice,
        'deleteInvoice' => self::deleteInvoice
    ];
}
