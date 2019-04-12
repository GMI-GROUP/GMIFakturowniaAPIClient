<?php

namespace Gmigroup\Clients\Fakturownia\Mapping;

class Mapping
{
    private const createInvoice = 'invoices.json';
    private const getInvoices = 'invoices.json';
    private const getInvoice = 'invoices/[ID].json';
    private const deleteInvoice = 'invoices/[ID].json';
    private const sendEmailInvoice = 'invoices/[ID]/send_by_email.json?api_token=[API_TOKEN]';

    public const ALL_METHODS = [
        'createInvoice' => self::createInvoice,
        'getInvoices' => self::getInvoices,
        'getInvoice' => self::getInvoice,
        'deleteInvoice' => self::deleteInvoice,
        'sendEmailInvoice' => self::sendEmailInvoice
    ];
}
