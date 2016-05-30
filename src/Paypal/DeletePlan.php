<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Plan;

/**
 * Class DeletePlan
 * @package Trifledev\Phpay\Paypal
 */
class DeletePlan
{

    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * DeletePlan constructor.
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
    function delete(Plan $createdPlan){

        return $createdPlan->delete($this->getAdapter()->getApiContext());

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