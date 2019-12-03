<?php

declare(strict_types=1);

namespace EuCheckVatService;

use EuCheckVatService\Client\CheckVatSoapClient;
use EuCheckVatService\Response\CheckVatResponse;
use Exception;

/**
 * Main class.
 *
 * @author CSoellinger <dev@csoellinger.at>
 */
class CheckVat
{
    /**
     * @var CheckVatSoapClient BMF session web service
     */
    private static $client;

    /**
     * Execute VAT check.
     *
     * @param string $countryCode
     * @param string $vat
     * @param bool   $fullCheck
     *
     * @throws Exception If country code or VAT is not valid.
     *
     * @return bool|CheckVatResponse
     */
    public static function exec(string $countryCode, string $vat, bool $fullCheck = false)
    {
        self::getService()->setParams($countryCode, $vat);

        if ($fullCheck === true) {
            return self::getService()->checkFull();
        }

        return self::getService()->check();
    }

    /**
     * Get soap service.
     */
    private static function getService(): CheckVatSoapClient
    {
        if (self::$client === null) {
            self::$client = new CheckVatSoapClient();
        }

        return self::$client;
    }
}
