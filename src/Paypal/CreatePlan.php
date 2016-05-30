<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;

/**
 * Class CreatePlan
 * @package Trifledev\Phpay\Paypal
 */
class CreatePlan
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

    /**
     * Create billing plan at paypal
     *
     * @param $name
     * @param $description
     * @param $amount
     * @param string $returnUrl
     * @param string $returnCancel
     * @param int $setupFee
     * @param bool $isTrial
     * @param string $currency
     * @param string $planType
     * @param string $definitionName
     * @param string $definitionType
     * @param string $definitionFrequency
     * @param string $definitionFrequencyInterval
     * @param string $definitionCycles
     * @param string $trialDefinitionName
     * @param string $trialDefinitionType
     * @param string $trialDefinitionFrequency
     * @param string $trialDefinitionFrequencyInterval
     * @param string $trialDefinitionCycles
     * @param string $trialDefinitionAmount
     * @return string
     */
    function create(
        $name,
        $description,
        $amount,
        $returnUrl='',
        $returnCancel='',
        $setupFee=0,
        $isTrial=false,
        $currency='USD',
        $planType='fixed',
        $definitionName='Regular Payments',
        $definitionType='REGULAR',
        $definitionFrequency='Month',
        $definitionFrequencyInterval='1',
        $definitionCycles='12',
        $trialDefinitionName='Trial Period',
        $trialDefinitionType='TRIAL',
        $trialDefinitionFrequency='0',
        $trialDefinitionFrequencyInterval='0',
        $trialDefinitionCycles='0',
        $trialDefinitionAmount='0'
    )
    {

        $plan = new Plan();

        $plan->setName($name)
            ->setDescription($description)
            ->setType($planType);

        $paymentDefinition = new PaymentDefinition();

        $paymentDefinition->setName($definitionName)
            ->setType($definitionType)
            ->setFrequency($definitionFrequency)
            ->setFrequencyInterval($definitionFrequencyInterval)
            ->setCycles($definitionCycles)
            ->setAmount(new Currency(array('value' => $amount, 'currency' => $currency)));

        $plan->setPaymentDefinitions(array($paymentDefinition));

        if($isTrial) {

            $paymentDefinitionTrial = new PaymentDefinition();

            $paymentDefinitionTrial->setName($trialDefinitionName)
                ->setType($trialDefinitionType)
                ->setFrequency($trialDefinitionFrequency)
                ->setFrequencyInterval($trialDefinitionFrequencyInterval)
                ->setCycles($trialDefinitionCycles)
                ->setAmount(new Currency(array('value' => $trialDefinitionAmount, 'currency' => $currency)));

            $plan->addPaymentDefinition($paymentDefinitionTrial);

        }
        $merchantPreferences = new MerchantPreferences();

        $merchantPreferences->setReturnUrl($returnUrl)
            ->setCancelUrl($returnCancel)
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => $setupFee, 'currency' => $currency)));
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $result = $plan->create($this->getAdapter()->getApiContext());

        if($result) {
            return [
                'plan'=>$result,
                'id'=>$result->getId(),
                'state'=>$result->getState(),
                'created'=>$result->getCreateTime()
            ];
        }
        return $result;

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