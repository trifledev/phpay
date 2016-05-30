<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;

/**
 * Class SuspendAgreement
 * @package Trifledev\Phpay\Paypal
 */
class SuspendAgreement
{
    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * SuspendAgreement constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Suspend billing agreement with paypal
     * @param object $createdAgreement Agreement
     * @param $agreementStateDescription
     * @return bool
     * @internal param string $agreementStateDescriptor
     */
    function suspend($createdAgreement,$agreementStateDescription) {

        //Create an Agreement State Descriptor, explaining the reason to suspend.
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote($agreementStateDescription);

        $createdAgreement->suspend($agreementStateDescriptor, $this->getAdapter()->getApiContext());

        // Lets get the updated Agreement Object
        return Agreement::get($createdAgreement->getId(), $this->getAdapter()->getApiContext());
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