<?php

namespace Gundo\ProductInfoAgent\Block;

use Exception;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Registry;
use Magento\Customer\Helper\Session\CurrentCustomer as CustomerSessionHelper;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManager;

class Chat extends Template
{
    /**
     * @var Registry
     */
    protected Registry $registry;

    /**
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;

    /**
     * @var CustomerSessionHelper
     */
    protected CustomerSessionHelper $customerSessionHelper;

    /**
     * @var StoreManager
     */
    protected StoreManager $storeManager;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ProductRepository $productRepository
     * @param CustomerSessionHelper $customerSessionHelper
     * @param StoreManager $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context      $context,
        Registry              $registry,
        ProductRepository     $productRepository,
        CustomerSessionHelper $customerSessionHelper,
        StoreManager          $storeManager,
        array                 $data = []
    ) {
        $this->registry = $registry;
        $this->productRepository = $productRepository;
        $this->customerSessionHelper = $customerSessionHelper;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return Product|null
     */
    public function getCurrentProduct(): ?Product
    {
        return $this->registry->registry('current_product');
    }

    /**
     * @return int
     */
    public function getCustomer(): int
    {
        try {

            return $this->customerSessionHelper->getCustomer()->getId();
        } catch (Exception $e) {
            unset($e);
            return 0;
        }
    }

    /**
     * @return string
     */
    public function agentEndpoint(): string
    {
        $baseUrl = $this->getBaseUrl();
        $baseUrl = explode('/', $baseUrl);
        $modelPath = '/rest/V1/productinfoagent/message';

        return $baseUrl[0] .'//'. $baseUrl[2]  . $modelPath;
    }
}
