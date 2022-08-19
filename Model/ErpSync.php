<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Model;

use Kheyfets\ErpOrderSync\Api\Data\ErpSyncInterface;
use Magento\Framework\Model\AbstractModel;

class ErpSync extends AbstractModel implements ErpSyncInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Kheyfets\ErpOrderSync\Model\ResourceModel\ErpSync::class);
    }

    /**
     * @inheritDoc
     */
    public function getErpSyncId(): ? string
    {
        return $this->getData(self::ERP_SYNC_ID);
    }

    /**
     * @inheritDoc
     */
    public function setErpSyncId($erpSyncId): ErpSyncInterface
    {
        return $this->setData(self::ERP_SYNC_ID, $erpSyncId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderId(): ? string
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderId($orderId): ErpSyncInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * @inheritDoc
     */
    public function getTimestamp(): ? string
    {
        return $this->getData(self::TIMESTAMP);
    }

    /**
     * @inheritDoc
     */
    public function setTimestamp($timestamp): ErpSyncInterface
    {
        return $this->setData(self::TIMESTAMP, $timestamp);
    }

    /**
     * @inheritDoc
     */
    public function getErpReturnCode(): ? string
    {
        return $this->getData(self::ERP_RETURN_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setErpReturnCode($erpReturnCode): ErpSyncInterface
    {
        return $this->setData(self::ERP_RETURN_CODE, $erpReturnCode);
    }
}

