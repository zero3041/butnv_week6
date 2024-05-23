<?php
declare(strict_types=1);

namespace Bss\InternShip\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class InternShip
 *
 * Model InternShip
 */
class Internship extends AbstractModel
{
    /**
     * Function constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Bss\InternShip\Model\ResourceModel\Internship::class);
    }
}
