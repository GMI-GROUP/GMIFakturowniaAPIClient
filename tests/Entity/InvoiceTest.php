<?php

namespace Gmigroup\Clients\Fakturownia\Tests\Entity;

use Gmigroup\Clients\Fakturownia\Entity\Invoice;
use Gmigroup\Clients\Fakturownia\Entity\InvoiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class InvoiceTest
 * @package Gmigroup\Clients\Fakturownia\Tests\Entity
 *
 * @group unit
 */
class InvoiceTest extends TestCase
{
    public const KIND = 'vat';
    public const SELL_DATE = '2019-04-03';
    public const SELLER_NAME = 'Kowalski sp z o.o.';
    public const SELLER_TAX_NO = '123456789';
    public const BUYER_NAME = 'Ryszard Nowak';
    public const BUYER_EMAIL = 'nowak@dev.gmi.pl';
    public const BUYER_TAX_NO = '987654321';
    public const POSITIONS = [
        [
            'name' => 'Produkt',
            'tax' => 23,
            'totalPriceGross' => 100.00,
            'quantity' => 1.00
        ]
    ];

    public const EXAMPLE_INVOICE = [
        'kind' => self::KIND,
        'sellDate' => self::SELL_DATE,
        'sellerName' => self::SELLER_NAME,
        'sellerTaxNo' => self::SELLER_TAX_NO,
        'buyerName' => self::BUYER_NAME,
        'buyerEmail' => self::BUYER_EMAIL,
        'buyerTaxNo' => self::BUYER_TAX_NO,
        'positions' => self::POSITIONS
    ];

    public function testCreateFromArray(): void
    {
        $invoice = Invoice::createFromArray(self::EXAMPLE_INVOICE);

        $this->assertInstanceOf(InvoiceInterface::class, $invoice);
        $this->assertEquals(self::KIND, $invoice->kind());
        $this->assertEquals(self::SELL_DATE, $invoice->sellDate());
        $this->assertEquals(self::SELL_DATE, $invoice->issueDate());
        $this->assertEquals(self::SELL_DATE, $invoice->paymentTo());
        $this->assertEquals(self::SELLER_NAME, $invoice->sellerName());
        $this->assertEquals(self::SELLER_TAX_NO, $invoice->sellerTaxNo());
        $this->assertEquals(self::BUYER_NAME, $invoice->buyerName());
        $this->assertEquals(self::BUYER_EMAIL, $invoice->buyerEmail());
        $this->assertEquals(self::BUYER_TAX_NO, $invoice->buyerTaxNo());
        $this->assertEquals(self::POSITIONS[0]['name'], $invoice->positions()[0]->name());
        $this->assertEquals(self::POSITIONS[0]['tax'], $invoice->positions()[0]->tax());
        $this->assertEquals(self::POSITIONS[0]['totalPriceGross'], $invoice->positions()[0]->totalPriceGross());
        $this->assertEquals(self::POSITIONS[0]['quantity'], $invoice->positions()[0]->quantity());
    }
}
