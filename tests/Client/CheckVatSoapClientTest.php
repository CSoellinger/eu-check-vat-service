<?php

declare(strict_types=1);

namespace Tests\EuCheckVatService\Client;

use EuCheckVatService\Client\CheckVatSoapClient;
use EuCheckVatService\Response\CheckVatResponse;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Testing check vat soap client.
 *
 * @covers \EuCheckVatService\Client\CheckVatSoapClient
 *
 * @internal
 */
class CheckVatSoapClientTest extends TestCase
{
    /**
     * @var CheckVatSoapClient Soap client
     */
    private static $client;

    /**
     * @var string Test country code
     */
    private static $countryCode = 'AT';

    /**
     * @var string Test VAT number
     */
    private static $uid = 'U65923833';

    /**
     * Calling before each test.
     *
     * @before
     */
    public function beforeTests(): void
    {
        self::$client = new CheckVatSoapClient();
    }

    /**
     * Test initialize soap client
     *
     * @testdox Test initialize soap client
     */
    public function testInitialize(): void
    {
        $checkVatSoapClient = self::$client;

        $this->assertInstanceOf(CheckVatSoapClient::class, $checkVatSoapClient);
    }

    /**
     * Test set and clear params
     *
     * @testdox Test set and clear params
     *
     * @throws Exception
     */
    public function testSetAndClearParams(): void
    {
        $checkVatSoapClient = self::$client;
        $checkVatSoapClient
            ->setParams(self::$countryCode, self::$uid)
            ->clearParams()
        ;

        $this->assertInstanceOf(CheckVatSoapClient::class, $checkVatSoapClient);
    }

    /**
     * Test full VAT check
     *
     * @testdox Test full VAT check
     *
     * @throws Exception
     */
    public function testFullCheck(): void
    {
        $checkVatSoapClient = self::$client;
        $fullCheck = $checkVatSoapClient
            ->setParams(self::$countryCode, self::$uid)
            ->checkFull()
        ;

        $this->assertInstanceOf(CheckVatSoapClient::class, $checkVatSoapClient);
        $this->assertInstanceOf(CheckVatResponse::class, $fullCheck);
        $this->assertTrue($fullCheck->valid);
    }

    /**
     * Test full VAT check (short writing)
     *
     * @testdox Test full VAT check (short writing)
     *
     * @throws Exception
     */
    public function testFullCheckFast(): void
    {
        $checkVatSoapClient = self::$client;
        $fullCheck = $checkVatSoapClient->checkFull(self::$countryCode, self::$uid);

        $this->assertInstanceOf(CheckVatSoapClient::class, $checkVatSoapClient);
        $this->assertInstanceOf(CheckVatResponse::class, $fullCheck);
        $this->assertTrue($fullCheck->valid);
    }

    /**
     * Test VAT check
     *
     * @testdox Test VAT check
     *
     * @throws Exception
     */
    public function testCheck(): void
    {
        $checkVatSoapClient = self::$client;
        $check = $checkVatSoapClient
            ->setParams(self::$countryCode, self::$uid)
            ->check()
        ;

        $this->assertInstanceOf(CheckVatSoapClient::class, $checkVatSoapClient);
        $this->assertTrue($check);
    }

    /**
     * Test VAT check (short writing)
     *
     * @testdox Test VAT check (short writing)
     *
     * @throws Exception
     */
    public function testCheckFast(): void
    {
        $checkVatSoapClient = self::$client;
        $check = $checkVatSoapClient->check(self::$countryCode, self::$uid);

        $this->assertInstanceOf(CheckVatSoapClient::class, $checkVatSoapClient);
        $this->assertTrue($check);
    }

    /**
     * Failure with wrong country code param
     *
     * @testdox Failure with wrong country code param
     *
     * @throws Exception
     */
    public function testFailureWithWrongCountryCodeParam(): void
    {
        $this->expectException(Exception::class);

        $checkVatSoapClient = self::$client;
        $checkVatSoapClient->setParams('', self::$uid);
    }

    /**
     * Failure with wrong UID param
     *
     * @testdox Failure with wrong UID param
     *
     * @throws Exception
     */
    public function testFailureWithWrongUidParam(): void
    {
        $this->expectException(Exception::class);

        $checkVatSoapClient = self::$client;
        $checkVatSoapClient->setParams(self::$countryCode, '');
    }
}
