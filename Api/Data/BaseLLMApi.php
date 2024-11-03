<?php

namespace Gundo\ProductInfoAgent\Api\Data;

use Gundo\ProductInfoAgent\Logger\Logger as LoggerInterface;
use Gundo\ProductInfoAgent\Helper\Data;

abstract class BaseLLMApi
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Data
     */
    private Data $configData;

    /**
     * @param LoggerInterface $logger
     * @param Data $configData
     */
    public function __construct(
        LoggerInterface $logger,
        Data            $configData
    )
    {
        $this->logger = $logger;
        $this->configData = $configData;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @param string $message
     * @return string
     */
    protected function callGeminiModel(string $message, $productData = ""): string
    {
        if(is_array($productData)) {
          $productData = json_encode($productData);
        }

        $systemPrompt = $this->configData->getSystemPrompt() ?? "
         You are a Online Shopping assistant named ProAgent.
                Answer the user's question with relevant information about the product, including:
                Product Info:.'$productData'.
                User question:";

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $systemPrompt . $message,
                        ]
                    ]
                ]
            ]
        ];


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyDdk9l0V0OKDgTTNR0Sjv71SN2VTFGeuAY', //. $this->configData->getApiKey(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $this->logger->info($response);

        $response = json_decode($response);

        return $response->candidates[0]->content->parts[0]->text ?? "No response found.";
    }

    /**
     * @param $message
     * @return string
     */
    protected function callOpenAiModel($message)
    {
        //TODO::ADD OPENAI Support
    }

    /**
     * @param $message
     * @return string
     */
    protected function callOllamaModel($message)
    {
        //TODO::ADD Ollama Support
    }
}
