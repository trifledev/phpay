<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Agreement;

/**
 * Class GetAgreement
 * @package Trifledev\Phpay\Paypal
 */
class GetAgreement
{
    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * GetAgreement constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Suspend billing agreement with paypal
     * @param $agreementId
     * @return bool
     * @internal param object $createdAgreement Agreement
     * @internal param string $agreementStateDescriptor
     */
    function get($agreementId) {

        return $agreement = Agreement::get($agreementId, $this->getAdapter()->getApiContext());
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