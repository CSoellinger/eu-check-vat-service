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
    private $client;

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
    public function exec(string $countryCode, string $vat, bool $fullCheck = false)
    {
        $this->getService()->setParams($countryCode, $vat);

        if ($fullCheck === true) {
            return $this->getService()->checkFull();
        }

        return $this->getService()->check();
    }

    /**
     * Get soap service.
     *
     * @return null|CheckVatSoapClient
     */
    private function getService()
    {
        if ($this->client === null) {
            $this->client = new CheckVatSoapClient();
        }

        return $this->client;
    }
}
