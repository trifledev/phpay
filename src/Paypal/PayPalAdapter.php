<?php
namespace Trifledev\Phpay\Paypal;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

/**
 * Class PayPalAdapter
 * @package Trifledev\Phpay\Paypal
 */
class PayPalAdapter
{

    /**
     * @var null|ApiContext
     */
    protected $apiContext;
    protected $clientId;
    protected $clientSecret;
    protected $logfile = './paypal.log';
    protected $appEndpoint = '';
    protected $paypalEndpoint = [
        'sandbox'=>'https://sandbox.paypal.com/cgi-bin/webscr',
        'live'=>'https://www.paypal.com/cgi-bin/webscr'
    ];
    protected $mode = 'sandbox';

    /**
     * PayPalAdapter constructor.
     * @param $clientId
     * @param $clientSecret
     * @param $appEndpoint
     * @param $logfile
     */
    function __construct($clientId, $clientSecret,$appEndpoint,$logfile) {

        $this->appEndpoint = $appEndpoint;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->logfile = $logfile;

    }
    function setMode($mode) {
        $this->mode = $mode;
    }
    function getPaypalEndpoint() {
        return $this->paypalEndpoint[$this->mode];
    }
    /**
     * Helper method for getting an APIContext for all calls
     * @return ApiContext
     */
    function getApiContext()
    {

        // ### Api context
        // Use an ApiContext object to authenticate
        // API calls. The clientId and clientSecret for the
        // OAuthTokenCredential class can be retrieved from
        // developer.paypal.com
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->clientId,
                $this->clientSecret
            )
        );
        // Comment this line out and uncomment the PP_CONFIG_PATH
        // 'define' block if you want to use static file
        // based configuration
        $apiContext->setConfig(
            array(
                'mode' => $this->mode,
                'log.LogEnabled' => true,
                'log.FileName' => $this->logfile,
                'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true,
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
                //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
            )
        );

        // Partner Attribution Id
        // Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
        // To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
        // $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');
        return $this->apiContext = $apiContext;
    }

    /**
     * @param $class
     * @return mixed
     */
    function getApi($class) {

        switch($class) {
            case 'CreatePlan':
                return new CreatePlan($this);
                break;
            case 'CreateAgreementPaypal':
                return new CreateAgreementPaypal($this);
                break;
            case 'ExecuteAgreement':
                return new ExecuteAgreement($this);
                break;
            case 'ActivatePlan': //@todo remove this entry, replaced by update
                return new ActivatePlan($this);
                break;
            case 'UpdatePlan':
                return new UpdatePlan($this);
                break;
            case 'DeletePlan':
                return new DeletePlan($this);
                break;
            case 'SuspendAgreement':
                return new SuspendAgreement($this);
                break;
            case 'GetPlan':
                return new GetPlan($this);
                break;
            case 'GetAgreement':
                return new GetAgreement($this);
                break;
            case 'ListPlans':
                return new ListPlans($this);
                break;
            case 'CancelAgreement':
                return new CancelAgreement($this);
                break;
            case 'UpdateAgreement':
                return new CancelAgreement($this);
                break;

        }

        return null;

    }

    /**
     * @return string
     */
    public function getAppEndpoint()
    {
        return $this->appEndpoint;
    }

    /**
     * @param string $appEndpoint
     */
    public function setAppEndpoint($appEndpoint)
    {
        $this->appEndpoint = $appEndpoint;
    }

}