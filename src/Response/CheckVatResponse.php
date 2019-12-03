<?php

declare(strict_types=1);

namespace EuCheckVatService\Response;

/**
 * Response class for VAT check
 */
class CheckVatResponse
{
    /**
     * @var string 2 letter country code
     */
    public $countryCode;

    /**
     * @var string VAT number
     */
    public $vatNumber;

    /**
     * @var string Date of VAT check request
     */
    public $requestDate;

    /**
     * @var bool If its valid
     */
    public $valid;

    /**
     * @var string (optional) Registered name for VAT
     */
    public $name;

    /**
     * @var string (optional) Registered address for VAT
     */
    public $address;
}
