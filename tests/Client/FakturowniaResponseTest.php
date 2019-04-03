<?php

namespace Gmigroup\Clients\Fakturownia\Tests\Client;

use Gmigroup\Clients\Fakturownia\Response\FakturowniaResponse;
use Gmigroup\Clients\Fakturownia\Response\FakturowniaResponseInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FakturowniaResponseTest
 * @package Gmigroup\Clients\Fakturownia\Tests\Client
 *
 * @group unit
 */
class FakturowniaResponseTest extends TestCase
{
    protected const SUCCESS_CODE = 200;
    protected const NOT_FOUND_CODE = 404;
    protected const OTHER_CODE = 500;
    protected const EXAMPLE_DATA = [
        'testKey1' => 123,
        'testKey2' => 234
    ];

    /**
     * @var FakturowniaResponseInterface
     */
    protected $fakturowniaResponse;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakturowniaResponse = new FakturowniaResponse(self::SUCCESS_CODE, self::EXAMPLE_DATA);
    }

    public function testGetData(): void
    {
        $this->assertEquals(self::EXAMPLE_DATA, $this->fakturowniaResponse->getData());
    }

    public function testGetStatusSuccessWithCode200(): void
    {
        $this->assertEquals(FakturowniaResponseInterface::STATUS_SUCCESS, $this->fakturowniaResponse->getStatus());
    }

    public function testGetStatusNotFoundWithCode404(): void
    {
        $fakturowniaResponse = new FakturowniaResponse(self::NOT_FOUND_CODE, []);

        $this->assertEquals(FakturowniaResponseInterface::STATUS_NOT_FOUND, $fakturowniaResponse->getStatus());
    }

    public function testGetStatusErrorWithCode500(): void
    {
        $fakturowniaResponse = new FakturowniaResponse(self::OTHER_CODE, []);

        $this->assertEquals(FakturowniaResponseInterface::STATUS_ERROR, $fakturowniaResponse->getStatus());
    }
}
