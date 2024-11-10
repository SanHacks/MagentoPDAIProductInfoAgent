<?php

namespace Gundo\ProductInfoAgent\ViewModel;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Helper\Session\CurrentCustomer as CustomerSessionHelper;

class CustomerData implements ArgumentInterface
{
    /**
     * @var CustomerSessionHelper
     */
    protected CustomerSessionHelper $customerSessionHelper;

    /**
     * @param CustomerSessionHelper $customerSessionHelper
     */
    public function __construct(CustomerSessionHelper $customerSessionHelper)
    {
        $this->customerSessionHelper = $customerSessionHelper;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->getCustomer()->getId();
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customerSessionHelper->getCustomer();
    }
}
