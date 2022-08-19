<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Block\Items;

use Kheyfets\ErpOrderSync\Api\ErpSyncRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Config\Exception\LoaderLoadException;

class Status extends \Magento\Framework\View\Element\Template
{
    private ErpSyncRepositoryInterface $erpSyncRepository;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        ErpSyncRepositoryInterface $erpSyncRepository,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->erpSyncRepository = $erpSyncRepository;
        parent::__construct($context, $data);
    }

    /**
     * @throws LocalizedException
     */
    public function getStatusTableData(): array
    {
        return $this->erpSyncRepository->getData();
    }
}

