<?php declare(strict_types=1);

namespace Gundo\ProductInfoAgent\Model;

use Exception;
use Gundo\ProductInfoAgent\Api\ChatInterface;
use Gundo\ProductInfoAgent\Helper\CollectAgentData\ApiDataCollection as LargeLanguageModelApi;
use Gundo\ProductInfoAgent\Logger\Logger;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Chat implements ChatInterface
{
    /**
     * @var LargeLanguageModelApi
     */
    private LargeLanguageModelApi $api;

    private ProductRepositoryInterface $productRepository;

    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @param Logger $logger
     * @param LargeLanguageModelApi $api
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Logger $logger,
        LargeLanguageModelApi      $api,
        ProductRepositoryInterface $productRepository
    ) {
        $this->logger = $logger;
        $this->api = $api;
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $message
     * @param int|null $productId
     * @param int|null $customerId
     * @return array
     */
    public function sendMessage(string $message, int $productId = null, int $customerId = null): array
    {
        try {
            $productData = '';

            if ($productId) {
                $productData = $this->productData($productId);
            }

            $response = $this->api->callProductAgent($message, $productData,$customer);

            return ['message' => $response];
        } catch (Exception $e) {
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
                'price' => "ZAR". $product->getPrice(),
                'short_description' => $product->getData('short_description'),
                'productId' => $product->getId(),
            ]
        ];
    }
}
