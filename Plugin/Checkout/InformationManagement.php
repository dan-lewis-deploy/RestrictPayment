<?php
/*
 * @Author:    Dan Lewis (dan.lewis@deploy.co.uk)
 * @Copyright: 2024 Deploy Ecommerce (https://www.deploy.co.uk)
 * @Package:   DeployEcommerce_RestrictPayment
 */

namespace DeployEcommerce\RestrictPayment\Plugin\Checkout;

use DeployEcommerce\RestrictPayment\Helper\Settings;
use Exception;

class InformationManagement
{

    /**
     * @param Settings $settings
     */
    public function __construct(
        protected Settings $settings
    )
    {
    }

    /**
     * @param $result
     * @return mixed
     */
    protected function filterPaymentMethods($result): mixed
    {
        $total = $result->getTotals()->getGrandTotal();
        if($this->settings->canRestrict($total)){
            $methods = $result->getPaymentMethods();
            $restrictions = explode(",", $this->settings->getConfig(Settings::MODULE_RESTRICTION_METHODS));
            foreach($result->getPaymentMethods() as $paymentMethodKey => $paymentMethod){
                if(in_array($paymentMethod->getCode(), $restrictions))
                    unset($methods[$paymentMethodKey]);
            }
            try{
                $result->setPaymentMethods($methods);
            }
            catch(Exception $exception){
                $this->settings->logError($exception->getMessage());
            }
        }
        return $result;
    }

}
