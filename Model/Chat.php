<?php

namespace Gundo\ProductInfoAgent\Model;

use Gundo\ProductInfoAgent\Api\ChatInterface;
use Gundo\ProductInfoAgent\Helper\CollectAgentData\ApiDataCollection as LargeLanguageModelApi;
use Gundo\ProductInfoAgent\Logger\Logger;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\EntityManager\EventManager;

class Chat implements ChatInterface
{
    /**
     * @var LargeLanguageModelApi
     */
    private LargeLanguageModelApi $api;

    private ProductRepositoryInterface $productRepository;

    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @param LargeLanguageModelApi $api
     */
    public function __construct(

        LargeLanguageModelApi      $api,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->api = $api;
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $message
     * @param null $productId
     * @return array
     * @throws NoSuchEntityException
     */
    public function sendMessage(string $message, $productId = null): array
    {
        try {
            $productData = '';

            if ($productId) {
                $productData = $this->productData($productId);
            }

            $response = $this->api->callProductAgent($message, $productData);

            return ['message' => $response];

        } catch (NoSuchEntityException $e) {
            $this->logger->critical($e);
            return [];
        }
    }

    /**
     * @param $productId
     * @return array[]
     * @throws NoSuchEntityException
     */
    public function productData($productId): array
    {
        $product = $this->productRepository->getById($productId);

        return [
            'details' => [
                'description' => $product->getData('description'),
                'product_name' => $product->getName(),
                'price' => $product->getPrice(),
                'short_description' => $product->getData('short_description'),
            ]
        ];
    }
}
