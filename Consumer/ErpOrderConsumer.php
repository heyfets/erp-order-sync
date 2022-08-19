<?php declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Consumer;

use Kheyfets\ErpOrderSync\Api\ErpOrdersManagementInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;

class ErpOrderConsumer
{
    private LoggerInterface $logger;
    private SerializerInterface $serializer;
    private ErpOrdersManagementInterface $erpOrdersManagement;

    public function __construct(
        ErpOrdersManagementInterface $erpOrdersManagement,
        LoggerInterface $logger,
        SerializerInterface $serializer
    ) {
        $this->erpOrdersManagement = $erpOrdersManagement;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    /**
     * @throws \Exception
     */
    public function process($operation): void
    {
        try {
            $data = $this->serializer->unserialize($operation);
            $this->erpOrdersManagement->export($data);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
