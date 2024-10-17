<?php
/*
 * @Author:    Dan Lewis (dan.lewis@deploy.co.uk)
 * @Copyright: 2024 Deploy Ecommerce (https://www.deploy.co.uk)
 * @Package:   DeployEcommerce_RestrictPayment
 */

namespace DeployEcommerce\RestrictPayment\Plugin\Checkout\Model;

use DeployEcommerce\RestrictPayment\Helper\Settings;
use Exception;
use Magento\Checkout\Api\Data\PaymentDetailsInterface;
use Magento\Checkout\Model\PaymentInformationManagement as MagentoPaymentInformationManagement;
use DeployEcommerce\RestrictPayment\Plugin\Checkout\InformationManagement;

class PaymentInformationManagement extends InformationManagement
{

    /**
     * @param Settings $settings
     */
    public function __construct(protected Settings $settings)
    {
        parent::__construct($settings);
    }

    /**
     * @param MagentoPaymentInformationManagement $subject
     * @param PaymentDetailsInterface $result
     * @param int $cartId
     * @return PaymentDetailsInterface
     * @throws Exception
     */
    public function afterGetPaymentInformation(
        MagentoPaymentInformationManagement $subject,
        PaymentDetailsInterface $result,
        int $cartId
    ): PaymentDetailsInterface
    {
        if(!$this->settings->isEnabled())
            return $result;
        return $this->filterPaymentMethods($result);
    }

}
