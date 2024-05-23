<?php
declare(strict_types=1);

namespace Bss\InternShip\Model\ResourceModel;

use Bss\InternShip\Model\Internship;
use Bss\InternShip\Model\ResourceModel\Internship as InternshipResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * Internship collection
 */
class Collection extends AbstractCollection
{
    /**
     * Constructor function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Internship::class, InternshipResourceModel::class);
    }
}
