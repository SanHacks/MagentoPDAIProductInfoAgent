<?php declare(strict_types=1);

namespace Gundo\ProductInfoAgent\Helper\CollectAgentData;

use Gundo\ProductInfoAgent\Api\Data\LargeLanguageModelApi as LLModelApi;
use Gundo\ProductInfoAgent\Helper\Data;
use Magento\Framework\Event\ManagerInterface as EventManager;

class ApiDataCollection
{
    /**
     * @var Data $configData
     */
    protected Data $configData;

    /**
     * @var LLModelApi
     */
    protected LLModelApi $largeLanguageModelApi;

    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @param EventManager $eventManager
     * @param Data $configData
     * @param LLModelApi $largeLanguageModelApi
     */
    public function __construct(
        EventManager $eventManager,
        Data         $configData,
        LLModelApi   $largeLanguageModelApi,
    ) {
        $this->eventManager = $eventManager;
        $this->configData = $configData;
        $this->largeLanguageModelApi = $largeLanguageModelApi;
    }

    /**
     * @param string $message
     * @param null $productDetails
     * @return string
     */
    public function callProductAgent(string $message, $productDetails = null): string
    {
        $response = "Sorry, I am currently unable to formulate the response, to question.";

        if ($message) {
            if ($productDetails) {
                $response = $this->largeLanguageModelApi->callModel($message, $productDetails);
            } else {
                $response = $this->largeLanguageModelApi->callModel($message);
            }

            $this->dispatchEvent($response);
        }

        return $response;
    }

    /**
     * @param string $eventData
     * @return void
     */
    public function dispatchEvent(string $eventData): void
    {
        $this->eventManager->dispatch(
            'product_info_agent_response_event',
            ['productInfoResponse' => $eventData]
        );
    }
}
