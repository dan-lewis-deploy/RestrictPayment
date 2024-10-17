<?php
/*
 * @Author:    Dan Lewis (dan.lewis@deploy.co.uk)
 * @Copyright: 2024 Deploy Ecommerce (https://www.deploy.co.uk)
 * @Package:   DeployEcommerce_RestrictPayment
 */

namespace DeployEcommerce\RestrictPayment\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Payment\Api\PaymentMethodListInterface;
use DeployEcommerce\RestrictPayment\Helper\Settings;
use Magento\Store\Model\StoreManagerInterface;


class ConfigOption implements OptionSourceInterface
{

    public function __construct(
        protected PaymentMethodListInterface $paymentMethodList,
        protected Settings $settings,
        protected StoreManagerInterface $storeManager
    )
    {
    }

    /**
     * @return array[]
     * @throws NoSuchEntityException
     */
    public function toOptionArray(): array
    {
        $options = [];
        $paymentMethods = $this->paymentMethodList->getList($this->storeManager->getStore()->getId());
        foreach($paymentMethods as $paymentMethod){
            $options[] = [
                'value' => $paymentMethod->getCode(),
                'label' => $paymentMethod->getTitle()
            ];
        }
        return $options;
    }
}
