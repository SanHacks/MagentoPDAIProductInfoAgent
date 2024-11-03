<?php
namespace Gundo\ProductInfoAgent\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Registry;

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
     * @param Template\Context $context
     * @param Registry $registry
     * @param ProductRepository $productRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        ProductRepository $productRepository,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get the current product.
     *
     * @return Product|null
     */
    public function getCurrentProduct(): ?Product
    {
        return $this->registry->registry('current_product');
    }
}
