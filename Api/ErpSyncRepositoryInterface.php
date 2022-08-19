<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Api;

use Kheyfets\ErpOrderSync\Api\Data\ErpSyncInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

interface ErpSyncRepositoryInterface
{

    /**
     * Save erp_sync
     * @param ErpSyncInterface $erpSync
     * @return ErpSyncInterface
     * @throws LocalizedException
     */
    public function save(
        ErpSyncInterface $erpSync
    ): Data\ErpSyncInterface;

    /**
     * Retrieve erp_sync
     * @param string $erpSyncId
     * @return ErpSyncInterface
     * @throws LocalizedException
     */
    public function get($erpSyncId): Data\ErpSyncInterface;

    /**
     * Retrieve erp_sync matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): \Magento\Framework\Api\SearchResults;

    /**
     * @param string $statusCode
     * @return array
     * * @throws LocalizedException
     */
    public function getData(string $statusCode): array;

    /**
     * Delete erp_sync
     * @param ErpSyncInterface $erpSync
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        ErpSyncInterface $erpSync
    ): bool;

    /**
     * Delete erp_sync by ID
     * @param string $erpSyncId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($erpSyncId): bool;
}

