<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Console\Command;

use Kheyfets\ErpOrderSync\Model\ErpSyncRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class Status extends Command
{
    const STATUS_TYPE_ARGUMENT = "status_type";

    private ErpSyncRepository $erpSyncRepository;

    public function __construct(
        ErpSyncRepository $erpSyncRepository,
        string $name = null
    ) {
        $this->erpSyncRepository = $erpSyncRepository;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $statusType = $input->getArgument(self::STATUS_TYPE_ARGUMENT);
        if (!in_array($statusType, ['success', 'failure'])) {
            return $output->writeln('<error>Please specify status_type argument with possible values "success" or "failure"</error>');
        }
        $items = $this->getResultTableData($statusType);
        $table = new Table($output);
        $table
            ->setHeaders(['Order ID', 'Timestamp', 'Return Code'])
            ->setRows($items);
        $table->render();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("erp:sync:status");
        $this->setDescription("The command will show a list of the last 10 successful and failed attempts of order data synchronization");
        $this->setDefinition([
            new InputArgument(self::STATUS_TYPE_ARGUMENT, InputArgument::REQUIRED, "Name"),
        ]);
        parent::configure();
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getResultTableData(string $statusType): array
    {
        return $this->erpSyncRepository->getData($statusType);
    }
}

