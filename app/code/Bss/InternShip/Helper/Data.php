<?php
declare(strict_types=1);

namespace Bss\InternShip\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * class Data
 *
 * get data url from configuration
 */
class Data extends AbstractHelper
{
    public const XML_PATH_CUSTOMER_DATA = 'bss_customer/general/internship_enable';

    /**
     * Function get value
     *
     * @param string $field
     * @param string $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    /**
     * Function get url
     *
     * @param string $storeId
     * @return mixed
     */
    public function getStatus($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOMER_DATA, $storeId);
    }
}
