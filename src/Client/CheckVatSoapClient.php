<?php

declare(strict_types=1);

namespace EuCheckVatService\Client;

use EuCheckVatService\Response\CheckVatResponse;
use Exception;
use SoapClient;

/**
 * Check vat service class.
 *
 * @author CSoellinger <dev@csoellinger.at>
 */
class CheckVatSoapClient extends SoapClient
{
    /**
     * @var string WSDL file (online path)
     */
    const WSDL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * @var array Class map for soap client
     */
    private static $classmap = [
        'checkVatResponse' => CheckVatResponse::class,
    ];

    /**
     * @var int Number of seconds to wait till timeout
     */
    private static $timeout = 10;

    /**
     * @var array|array<string,array<string,mixed>> Responses saved in an array for faster re-accessing response informations
     */
    private $responses;

    /**
     * @var string Country code to check
     */
    private $countryCode = '';

    /**
     * @var string VAT to check
     */
    private $vat = '';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(self::WSDL, $this->getOptions());
    }

    /**
     * Set country code and VAT params.
     *
     * @param string $countryCode 2 letter country code
     * @param string $vat         VAT number
     *
     * @throws Exception If country code or VAT is not valid
     */
    public function setParams(string $countryCode, string $vat): CheckVatSoapClient
    {
        if ($countryCode) {
            $this->countryCode = $countryCode;
        }

        if ($vat) {
            $this->vat = $vat;
        }

        $this->validateParams();

        return $this;
    }

    /**
     * Clear params.
     */
    public function clearParams(): CheckVatSoapClient
    {
        $this->countryCode = '';
        $this->vat = '';

        return $this;
    }

    /**
     * Run VAT check.
     *
     * @param string $countryCode 2 letter country code
     * @param string $vat         VAT number
     *
     * @throws Exception If country code or VAT is not valid.
     */
    public function check(string $countryCode = '', string $vat = ''): bool
    {
        return ((bool) $this->checkFull($countryCode, $vat)->valid === true);
    }

    /**
     * Run full VAT check. Response is not just true/false, also getting name and address.
     *
     * @param string $countryCode 2 letter country code
     * @param string $vat         VAT number
     *
     * @throws Exception If country code or VAT is not valid.
     */
    public function checkFull(string $countryCode = '', string $vat = ''): CheckVatResponse
    {
        $this->setParams($countryCode, $vat);

        if (isset($this->responses[$this->countryCode][$this->vat]) === false) {
            $params = [
                'countryCode' => $this->countryCode,
                'vatNumber' => $this->vat,
            ];

            $this->responses[$this->countryCode][$this->vat] = $this->__soapCall(
                'checkVat',
                [
                    $params,
                ]
            );
        }

        return $this->responses[$this->countryCode][$this->vat];
    }

    /**
     * Check params.
     *
     * @throws Exception If country code or VAT is not valid
     */
    private function validateParams(): void
    {
        if (!preg_match('/[A-Z]{2}/', $this->countryCode)) {
            throw new Exception('Country code is not valid or set.');
        }

        if (!preg_match('/[0-9A-Za-z\+\*\.]{2,12}/', $this->vat)) {
            throw new Exception('VAT is not valid or set.');
        }
    }

    /**
     * Get soap client options.
     *
     * @return array|array<string,mixed>
     */
    private function getOptions()
    {
        $options = [
            'connection_timeout' => self::$timeout,
        ];

        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }

        return $options;
    }
}
