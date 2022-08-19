<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ErpSync extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('kheyfets_erp_sync', 'erp_sync_id');
    }
}

