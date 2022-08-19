<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Model\ResourceModel\ErpSync;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'erp_sync_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Kheyfets\ErpOrderSync\Model\ErpSync::class,
            \Kheyfets\ErpOrderSync\Model\ResourceModel\ErpSync::class
        );
    }
}

