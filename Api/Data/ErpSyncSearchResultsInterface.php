<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Api\Data;

interface ErpSyncSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get erp_sync list.
     * @return \Kheyfets\ErpOrderSync\Api\Data\ErpSyncInterface[]
     */
    public function getItems(): array;

    /**
     * Set order_id list.
     * @param \Kheyfets\ErpOrderSync\Api\Data\ErpSyncInterface[] $items
     * @return $this
     */
    public function setItems(array $items): static;
}

