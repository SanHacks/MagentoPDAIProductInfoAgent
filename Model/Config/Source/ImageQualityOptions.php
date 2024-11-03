<?php declare(strict_types=1);

namespace Gundo\ProductInfoAgent\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ImageQualityOptions implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $imageQualityOptions = [
            '500' => 'Low (500)',
            '750' => 'Medium (750)',
            '1000' => 'High (1000)'
        ];

        $options = [];
        foreach ($imageQualityOptions as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }
}
