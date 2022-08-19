<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Api\Data;

interface ErpSyncInterface
{

    const ERP_RETURN_CODE = 'erp_return_code';
    const ORDER_ID = 'order_id';
    const TIMESTAMP = 'timestamp';
    const ERP_SYNC_ID = 'erp_sync_id';

    /**
     * Get erp_sync_id
     * @return string|null
     */
    public function getErpSyncId(): ?string;

    /**
     * Set erp_sync_id
     * @param string $erpSyncId
     * @return ErpSyncInterface
     */
    public function setErpSyncId($erpSyncId): ErpSyncInterface;

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId(): ?string;

    /**
     * Set order_id
     * @param string $orderId
     * @return ErpSyncInterface
     */
    public function setOrderId($orderId): ErpSyncInterface;

    /**
     * Get timestamp
     * @return string|null
     */
    public function getTimestamp(): ?string;

    /**
     * Set timestamp
     * @param string $timestamp
     * @return ErpSyncInterface
     */
    public function setTimestamp($timestamp): ErpSyncInterface;

    /**
     * Get erp_return_code
     * @return string|null
     */
    public function getErpReturnCode(): ?string;

    /**
     * Set erp_return_code
     * @param string $erpReturnCode
     * @return ErpSyncInterface
     */
    public function setErpReturnCode($erpReturnCode): ErpSyncInterface;
}

