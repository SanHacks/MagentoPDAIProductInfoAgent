<?php declare(strict_types=1);

namespace Gundo\ProductInfoAgent\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class AvailableModels implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $models = [
            'gemini' => 'Google Gemini',
            'gpt4' => 'OpenAI GPT4',
            'claude' => 'Claude',
            'ollama' => 'Ollama(Self-Hosted)'
        ];

        $options = [];
        foreach ($models as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }
}
