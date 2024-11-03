<?php

namespace Gundo\ProductInfoAgent\Model;

use Gundo\ProductInfoAgent\Model\ResourceModel\ProductInfoAgent\Collection;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\ObjectManagerInterface;

class CollectionFactory
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * CollectionFactory constructor.
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * Create a new collection instance.
     *
     * @return Collection
     */
    public function create(): Collection
    {
        return $this->objectManager->create(Collection::class);
    }
}
