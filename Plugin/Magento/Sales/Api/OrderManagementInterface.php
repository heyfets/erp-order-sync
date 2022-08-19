<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Plugin\Magento\Sales\Api;

use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Psr\Log\LoggerInterface;

class OrderManagementInterface
{
    /**
     * @var PublisherInterface
     */
    private PublisherInterface $publisher;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
        PublisherInterface $publisher
    ) {
        $this->logger = $logger;
        $this->publisher = $publisher;
    }

    public function afterPlace(
        \Magento\Sales\Api\OrderManagementInterface $subject,
        $result,
        OrderInterface $order
    ) {
        $data = [
            'orderId' => $order->getId(),
            'email' => $order->getCustomerEmail(),
            'cart_amount' => $order->getTotalQtyOrdered()
        ];
        $this->publisher->publish('erp_orders_sync.export', json_encode($data));
        $this->logger->info(sprintf(
                'The order #%s was placed by a customer with an email %s and cart amount of %s item(s).',
                $order->getId(),
                $order->getCustomerEmail(),
                $order->getTotalQtyOrdered()
            )
        );
        return $result;
    }
}

