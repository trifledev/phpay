<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;

class CreateAgreementPaypal
{

    /**
     * @var null|PayPalAdapter
     */
    private $adapter = null;

    /**
     * CreateAgreementPaypal constructor.
     * @param PayPalAdapter $adapter
     */
    function __construct(PayPalAdapter $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * Create billing agreement with paypal
     * @param $createdPlan
     * @param $agreementName
     * @param $agreementDescription
     * @param string $startTime
     * @return null|string Redirect url
     */
    function create($createdPlan, $agreementName, $agreementDescription, $startTime='') {

        if(empty($startTime)) {
            $time = time() + (30 * (24*3600));
            $startTime = date('Y-m-d\TH:i:s\Z',$time);
        }

        $agreement = new Agreement();
        $agreement->setName($agreementName)
            ->setDescription($agreementDescription)
            ->setStartDate($startTime);
        // Add Plan ID
        $plan = new Plan();
        $plan->setId($createdPlan['id']);
        $agreement->setPlan($plan);
        // Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
        $agreement = $agreement->create($this->getAdapter()->getApiContext());
        // ### Get redirect url
        // The API response provides the url that you must redirect
        // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
        // method
        return $agreement->getApprovalLink();

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