<?php
/*
 * @Author:    Dan Lewis (dan.lewis@deploy.co.uk)
 * @Copyright: 2024 Deploy Ecommerce (https://www.deploy.co.uk)
 * @Package:   DeployEcommerce_RestrictPayment
 */

namespace DeployEcommerce\RestrictPayment\Plugin\Checkout\Model;

use Magento\Checkout\Api\Data\PaymentDetailsInterface;
use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Model\ShippingInformationManagement as MagentoShippingInformationManagement;
use DeployEcommerce\RestrictPayment\Helper\Settings;
use DeployEcommerce\RestrictPayment\Plugin\Checkout\InformationManagement;

class ShippingInformationManagement extends InformationManagement
{

    /**
     * @param Settings $settings
     */
    public function __construct(protected Settings $settings)
    {
        parent::__construct($settings);
    }

    /**
     * @param MagentoShippingInformationManagement $subject
     * @param PaymentDetailsInterface $result
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return PaymentDetailsInterface
     * @throws \Exception
     */
    public function afterSaveAddressInformation(
        MagentoShippingInformationManagement $subject,
        PaymentDetailsInterface              $result,
        int                                  $cartId,
        ShippingInformationInterface         $addressInformation
    ): PaymentDetailsInterface
    {
        if(!$this->settings->isEnabled())
            return $result;
        return $this->filterPaymentMethods($result);
    }

}
