<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Agreement;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;

/**
 * Class UpdateAgreement
 * @package Trifledev\Phpay\Paypal
 */
class UpdateAgreement
{
    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * UpdateAgreement constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Update existing billing agreement at paypal
     * @param $agreementId
     * @param array $params
     * @return bool
     * @internal param object $createdAgreement Agreement
     */
    function update($agreementId,$params) {

        $patch = new Patch();
        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($params);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);
        try {

            $agreement = Agreement::get($agreementId, $this->getAdapter()->getApiContext());
            $agreement->update($patchRequest, $this->getAdapter()->getApiContext());

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