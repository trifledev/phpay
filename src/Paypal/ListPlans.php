<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Plan;

/**
 * Class ListPlans
 * @package Trifledev\Phpay\Paypal
 */
class ListPlans
{

    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * CreatePlan constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    function get($params=[]) {

        try {

            return $planList = Plan::all($params, $this->getAdapter()->getApiContext());

        } catch (\Exception $ex) {

            //@todo add logging

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