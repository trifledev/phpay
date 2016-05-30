<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Agreement;

/**
 * Class ExecuteAgreement
 * @package Trifledev\Phpay\Paypal
 */
class ExecuteAgreement
{

    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * ExecuteAgreement constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Execute agreement
     * @param $token
     * @return Agreement
     */
    function execute($token) {

        $agreement = new Agreement();

        return $agreement->execute($token, $this->getAdapter()->getApiContext());

    }
    /**
     * @return PayPalAdapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param PayPalAdapter $adapter
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

}