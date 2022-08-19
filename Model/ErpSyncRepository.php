<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Model;

use Kheyfets\ErpOrderSync\Api\Data\ErpSyncInterface;
use Kheyfets\ErpOrderSync\Api\Data\ErpSyncInterfaceFactory;
use Kheyfets\ErpOrderSync\Api\Data\ErpSyncSearchResultsInterfaceFactory;
use Kheyfets\ErpOrderSync\Api\ErpSyncRepositoryInterface;
use Kheyfets\ErpOrderSync\Model\ResourceModel\ErpSync as ResourceErpSync;
use Kheyfets\ErpOrderSync\Model\ResourceModel\ErpSync\CollectionFactory as ErpSyncCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class ErpSyncRepository implements ErpSyncRepositoryInterface
{

    /**
     * @var ErpSyncInterfaceFactory
     */
    protected $erpSyncFactory;

    /**
     * @var ResourceErpSync
     */
    protected $resource;

    /**
     * @var ErpSyncCollectionFactory
     */
    protected $erpSyncCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ErpSync
     */
    protected $searchResultsFactory;
    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;


    /**
     * @param ResourceErpSync $resource
     * @param ErpSyncInterfaceFactory $erpSyncFactory
     * @param ErpSyncCollectionFactory $erpSyncCollectionFactory
     * @param ErpSyncSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceErpSync $resource,
        ErpSyncInterfaceFactory $erpSyncFactory,
        ErpSyncCollectionFactory $erpSyncCollectionFactory,
        ErpSyncSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resource = $resource;
        $this->erpSyncFactory = $erpSyncFactory;
        $this->erpSyncCollectionFactory = $erpSyncCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function save(ErpSyncInterface $erpSync): ErpSyncInterface
    {
        try {
            $this->resource->save($erpSync);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the erpSync: %1',
                $exception->getMessage()
            ));
        }
        return $erpSync;
    }

    /**
     * @inheritDoc
     */
    public function get($erpSyncId): ErpSyncInterface
    {
        $erpSync = $this->erpSyncFactory->create();
        $this->resource->load($erpSync, $erpSyncId);
        if (!$erpSync->getId()) {
            throw new NoSuchEntityException(__('erp_sync with id "%1" does not exist.', $erpSyncId));
        }
        return $erpSync;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : SearchResults
    {
        $collection = $this->erpSyncCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @throws LocalizedException
     */
    public function getData($statusType = null): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->setPageSize(10);

        if ($statusType === 'success') {
            $searchCriteria->addFilter(ErpSyncInterface::ERP_RETURN_CODE, '200');
        } else {
            $searchCriteria->addFilter(ErpSyncInterface::ERP_RETURN_CODE, '200', 'neq');
        }
        $searchCriteria->create();
        return $this->getList($searchCriteria)->getItems();

    }

    /**
     * @param int $orderId
     * @param int $returnCode
     * @return void
     */
    public function setData(int $orderId, int $returnCode): void
    {
        $this->erpSyncFactory->create()
            ->setData([
                'order_id' => $orderId,
                'erp_return_code' => $returnCode
            ])
            ->setHasDataChanges(true)
            ->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(ErpSyncInterface $erpSync): bool
    {
        try {
            $erpSyncModel = $this->erpSyncFactory->create();
            $this->resource->load($erpSyncModel, $erpSync->getErpSyncId());
            $this->resource->delete($erpSyncModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the erp_sync: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($erpSyncId): bool
    {
        return $this->delete($this->get($erpSyncId));
    }
}

