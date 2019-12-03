<?php

declare(strict_types=1);

namespace Tests\EuCheckVatService\Client;

use EuCheckVatService\CheckVat;
use EuCheckVatService\Response\CheckVatResponse;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Testing check vat.
 *
 * @covers \EuCheckVatService\CheckVat
 * @covers \EuCheckVatService\Client\CheckVatSoapClient
 *
 * @internal
 */
class CheckVatTest extends TestCase
{
    /**
     * @var string Test country code
     */
    private static $countryCode = 'AT';

    /**
     * @var string Test VAT number
     */
    private static $uid = 'U65923833';

    /**
     * Test check VAT full
     *
     * @testdox Test check VAT full
     *
     * @throws Exception
     */
    public function testCheckVatFull(): void
    {
        $fullCheck = (new CheckVat())->exec(self::$countryCode, self::$uid, true);

        // $this->assertInstanceOf(CheckVatResponse::class, $fullCheck);
        $this->assertTrue($fullCheck->valid);
    }

    /**
     * Test check VAT
     *
     * @testdox Test check VAT
     *
     * @throws Exception
     */
    public function testCheckVat(): void
    {
        $check = (new CheckVat())->exec(self::$countryCode, self::$uid);

        $this->assertTrue($check);
    }
}
