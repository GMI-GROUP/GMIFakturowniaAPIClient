<?php

namespace Gmigroup\Clients\Fakturownia\Tests\Client;

use Gmigroup\Clients\Fakturownia\Client\Fakturownia;
use Gmigroup\Clients\Fakturownia\Entity\Invoice;
use Gmigroup\Clients\Fakturownia\Exception\InvalidTokenException;
use Gmigroup\Clients\Fakturownia\Response\FakturowniaResponseInterface;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Response;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

/**
 * Class FakturowniaTest
 * @package Gmigroup\Clients\Fakturownia\Tests\Client
 *
 * @group unit
 */
class FakturowniaTest extends TestCase
{
    protected const API_USERNAME = 'gmi1';
    protected const EXPECTED_API_URL = 'https://gmi1.fakturownia.pl/';
    protected const API_TOKEN = 'example_Token!@#/gmi1';

    protected const KIND = 'vat';
    protected const SELL_DATE = '2019-04-03';
    protected const SELLER_NAME = 'Kowalski sp z o.o.';
    protected const SELLER_TAX_NO = '123456789';
    protected const BUYER_NAME = 'Ryszard Nowak';
    protected const BUYER_EMAIL = 'nowak@dev.gmi.pl';
    protected const BUYER_TAX_NO = '987654321';
    protected const POSITIONS = [
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

    /**
     * @var ClientInterface
     */
    protected $mockGuzzle;

    /**
     * @var Fakturownia
     */
    protected $fakturownia;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockGuzzle = $this->createMock(Client::class);
        $this->mockGuzzle->expects($this->any())
            ->method('setBaseUrl')
            ->willReturn($this->mockGuzzle);

        $this->fakturownia = new Fakturownia($this->mockGuzzle, self::API_TOKEN);
    }

    public function testInit(): void
    {
        $reflection = new ReflectionObject($this->fakturownia);

        $expectedApiUrl = $reflection->getProperty('baseUrl');
        $expectedApiToken = $reflection->getProperty('apiToken');
        $expectedApiUrl->setAccessible(true);
        $expectedApiToken->setAccessible(true);

        $this->assertEquals(self::EXPECTED_API_URL, $expectedApiUrl->getValue($this->fakturownia));
        $this->assertEquals(self::API_TOKEN, $expectedApiToken->getValue($this->fakturownia));
    }

    public function testRequestExpectInvalidApiMethod(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupperted API method: example');

        $this->fakturownia->request('example');
    }

    public function testInitWithInvalidToken(): void
    {
        $this->expectException(InvalidTokenException::class);

        new Fakturownia($this->mockGuzzle, 'example');
    }

    public function testGetInvoices(): FakturowniaResponseInterface
    {
        $mockResponse = $this->createMock(Response::class);
        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([
                [
                    'id' => 1
                ]
            ]));
        $this->mockGuzzle->expects($this->once())
            ->method('send')
            ->willReturn($mockResponse);


        $fakturownia = new Fakturownia($this->mockGuzzle, self::API_TOKEN);

        $invoicesResponse = $fakturownia->getInvoices();

        $this->assertArrayHasKey('code', $invoicesResponse->toArray());
        $this->assertArrayHasKey('status', $invoicesResponse->toArray());
        $this->assertArrayHasKey('data', $invoicesResponse->toArray());
        $this->assertArrayHasKey('id', ($invoicesResponse->toArray())['data'][0]);

        return $invoicesResponse;
    }

    /**
     * @depends testGetInvoices
     */
    public function testGetInvoice(FakturowniaResponseInterface $testGetInvoices): void
    {
        $id = $testGetInvoices->getData()[0]['id'];

        $mockResponse = $this->createMock(Response::class);
        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([
                [
                    'id' => 1
                ]
            ]));
        $this->mockGuzzle->expects($this->once())
            ->method('send')
            ->willReturn($mockResponse);

        $fakturownia = new Fakturownia($this->mockGuzzle, self::API_TOKEN);

        $invoiceResponse = $fakturownia->getInvoice($id);

        $this->assertArrayHasKey('code', $invoiceResponse->toArray());
        $this->assertArrayHasKey('status', $invoiceResponse->toArray());
        $this->assertArrayHasKey('data', $invoiceResponse->toArray());
    }

    public function testCreateInvoice(): void
    {
        $mockResponse = $this->createMock(Response::class);
        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([
                [
                    'id' => 1
                ]
            ]));
        $this->mockGuzzle->expects($this->once())
            ->method('send')
            ->willReturn($mockResponse);

        $fakturownia = new Fakturownia($this->mockGuzzle, self::API_TOKEN);

        $createInvoiceResponse = $fakturownia->createInvoice(Invoice::createFromArray(self::EXAMPLE_INVOICE));

        $this->assertArrayHasKey('code', $createInvoiceResponse->toArray());
        $this->assertArrayHasKey('status', $createInvoiceResponse->toArray());
        $this->assertArrayHasKey('data', $createInvoiceResponse->toArray());
        $this->assertArrayHasKey('id', ($createInvoiceResponse->toArray())['data'][0]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->mockGuzzle = null;
    }
}
