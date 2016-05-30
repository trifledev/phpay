<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\Plan;
use PayPal\Common\PayPalModel;

/**
 * Class UpdatePlan
 * @package Trifledev\Phpay\Paypal
 */
class UpdatePlan
{

    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * UpdatePlan constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Update plan at paypal
     * @param Plan $createdPlan
     * @param $state
     * @return Plan
     */
    function update(Plan $createdPlan,$state){

        $patch = new Patch();
        $value = new PayPalModel('{
	       "state":"'.$state.'"
	     }');

        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);
        $createdPlan->update($patchRequest, $this->getAdapter()->getApiContext());

        if($state!='deleted') {

            $result = Plan::get($createdPlan->getId(), $this->getAdapter()->getApiContext());

            if($result) {
                return [
                    'plan'=>$result,
                    'id'=>$result->getId(),
                    'state'=>$result->getState(),
                    'created'=>$result->getCreateTime()
                ];
            }
        }

        return null;

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