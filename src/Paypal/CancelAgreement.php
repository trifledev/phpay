<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;

/**
 * Class CancelAgreement
 * @package Payment\Paypal
 */
class CancelAgreement
{
    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * CancelAgreement constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Update existing billing agreement at paypal
     * @param $agreementId
     * @param string $description
     * @return bool
     * @internal param object $createdAgreement Agreement
     */
    function cancel($agreementId,$description="Cancelling the agreement") {

        $agreement = Agreement::get($agreementId, $this->getAdapter()->getApiContext());

        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote($description);

        try {

            $agreement->cancel($agreementStateDescriptor, $this->getAdapter()->getApiContext());

        } catch (\Exception $ex) {

            //@todo add some logging

        }

        return true;

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