<?php declare(strict_types=1);

namespace Gundo\ProductInfoAgent\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    private const PRODUCTINFOAGENT_GENERAL_SYSTEM_PROMPT = 'productinfoagent/general/system_prompt';
    private const PRODUCTINFOAGENT_AUTH_API_KEY = 'productinfoagent/auth/api_key';
    private const PRODUCTINFOAGENT_GENERAL_API_SECRET = 'productinfoagent/general/api_secret';
    private const PRODUCTINFOAGENT_GENERAL_ALLOW_GUESTS = 'productinfoagent/general/allow_guests';
    private const PRODUCTINFOAGENT_GENERAL_SAVE_TO_CUSTOMER_ACCOUNT = 'productinfoagent/general/save_to_customer_account';
    private const PRODUCTINFOAGENT_GENERAL_SAVE_TO_DATABASE = 'productinfoagent/general/save_to_database';
    private const PRODUCTINFOAGENT_GENERAL_CUSTOMER_GROUPS = 'productinfoagent/general/customer_groups';
    private const PRODUCTINFOAGENT_GENERAL_IMAGE_QUALITY = 'productinfoagent/general/image_quality';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context              $context,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check if ProductInfoAgent is enabled.
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function isProductInfoAgentEnabled($storeId = null): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::PRODUCTINFOAGENT_AUTH_API_KEY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param string $path
     * @param int|string|null $storeId
     * @return string|null
     */
    private function getValue(string $path, $storeId = null): ?string
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int|string|null $storeId
     * @return string|null
     */
    public function getApiKey($storeId = null): ?string
    {
        return $this->getValue(self::PRODUCTINFOAGENT_AUTH_API_KEY, $storeId);
    }

    /**
     * @return string|null
     */
    public function getSystemPrompt(): ?string
    {
        return $this->getValue(self::PRODUCTINFOAGENT_GENERAL_SYSTEM_PROMPT);
    }

    /**
     * @param int|string|null $storeId
     * @return string|null
     */
    public function getApiSecret($storeId = null): ?string
    {
        return $this->getValue(self::PRODUCTINFOAGENT_GENERAL_API_SECRET, $storeId);
    }

    /**
     * @param int|string|null $storeId
     * @return bool
     */
    public function isGuestAllowed($storeId = null): bool
    {
        return $this->getFlag(self::PRODUCTINFOAGENT_GENERAL_ALLOW_GUESTS, $storeId);
    }

    /**
     * @param string $path
     * @param int|string|null $storeId
     * @return bool
     */
    private function getFlag(string $path, $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int|string|null $storeId
     * @return array
     */
    public function getCustomerGroups($storeId = null): array
    {
        $customerGroups = $this->scopeConfig->getValue(
            self::PRODUCTINFOAGENT_GENERAL_CUSTOMER_GROUPS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $customerGroups ? explode(',', $customerGroups) : [];
    }

    /**
     * @param int|string|null $storeId
     * @return bool
     */
    public function isSaveToCustomerAccount($storeId = null): bool
    {
        return $this->getFlag(self::PRODUCTINFOAGENT_GENERAL_SAVE_TO_CUSTOMER_ACCOUNT, $storeId);
    }

    /**
     * @param int|string|null $storeId
     * @return bool
     */
    public function isAllowedToSave($storeId = null): bool
    {
        return $this->getFlag(self::PRODUCTINFOAGENT_GENERAL_SAVE_TO_DATABASE, $storeId);
    }

    /**
     * @return string|null
     */
    public function getImageConfig(): ?string
    {
        return $this->scopeConfig->getValue(self::PRODUCTINFOAGENT_GENERAL_IMAGE_QUALITY);
    }
}
