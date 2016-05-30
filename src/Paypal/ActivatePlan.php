<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\Plan;
use PayPal\Common\PayPalModel;

/**
 * Class ActivatePlan
 * @package Trifledev\Phpay\Paypal
 */
class ActivatePlan
{

    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * ActivatePlan constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * @param $createdPlan
     * @return Plan
     */
    function activate(Plan $createdPlan){

        $patch = new Patch();
        $value = new PayPalModel('{
	       "state":"ACTIVE"
	     }');
        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);
        $createdPlan->update($patchRequest, $this->getAdapter()->getApiContext());
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