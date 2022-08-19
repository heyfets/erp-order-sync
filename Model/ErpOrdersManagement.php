<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Model;

use Kheyfets\ErpOrderSync\Api\ErpOrdersManagementInterface;
use Kheyfets\ErpOrderSync\Model\ErpSyncRepository;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;


class ErpOrdersManagement implements ErpOrdersManagementInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Curl
     */
    private $curl;
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var \Kheyfets\ErpOrderSync\Model\ErpSyncRepository
     */
    private \Kheyfets\ErpOrderSync\Model\ErpSyncRepository $erpSyncRepository;

    public function __construct(
        Curl $curl,
        ScopeConfigInterface $config,
        LoggerInterface $logger,
        OrderRepositoryInterface $orderRepository,
        ErpSyncRepository $ErpSyncRepository
    ) {
        $this->config = $config;
        $this->curl = $curl;
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        $this->erpSyncRepository = $ErpSyncRepository;
    }


    /**
     * @inheritDoc
     */
    public function export($data): void
    {
//        $statusCode = $this->sendData($data); ToDo implement ERP connection/response test case
        $statusCode = 200;
        if ($statusCode === 200) {
            $this->setOrderStatus($data['orderId']);
        }
        $this->logResult($data['orderId'], $statusCode);
    }

    private function sendData(mixed $data): int
    {
        $params = json_encode($data);

        try {
            $this->curl->addHeader('Content-Type', 'application/json');
            $url = $this->getErpEndpoint();
            $this->curl->post($url, $params);
            return $this->curl->getStatus();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->curl->getStatus();
        }
    }

    private function getErpEndpoint(): string
    {
        // ToDO add endpoint from store config
        return '';
    }

    private function setOrderStatus($orderID): void
    {
        try {
            $order = $this->orderRepository->get($orderID);
            $order->setState(Order::STATE_PROCESSING)->setStatus(Order::STATE_PROCESSING);
            $this->orderRepository->save($order);
            return;
        } catch (\Exception $e){
            $this->logger->error($e->getMessage());
            return;
        }
    }

    private function logResult($orderId, int $returnCode): void
    {
        $this->erpSyncRepository->setData((int) $orderId, $returnCode);
    }

}
