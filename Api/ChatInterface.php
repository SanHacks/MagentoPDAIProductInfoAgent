<?php

namespace Gundo\ProductInfoAgent\Api;

interface ChatInterface
{
    /**
     * @param string $message
     * @param int $productId
     * @param string $productName
     * @return array
     */
    public function sendMessage(string $message,int $productId): array;
}
