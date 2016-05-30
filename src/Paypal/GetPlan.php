<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Plan;

/**
 * Class GetPlan
 * @package Trifledev\Phpay\Paypal
 */
class GetPlan
{
    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Get paypal plan
     * @param $planId
     * @return Plan
     */
    function get($planId){

        return Plan::get($planId, $this->getAdapter()->getApiContext());

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