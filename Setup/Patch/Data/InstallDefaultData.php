<?php declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Kheyfets\ErpOrderSync\Model\ResourceModel\ErpSync as ErpSyncResource;

class InstallDefaultData implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;

    private ErpSyncResource $erpSyncResource;

    public function __construct(
        ErpSyncResource $erpSyncResource,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->erpSyncResource = $erpSyncResource;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     *
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     *
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $data = ['order_id' => 0, 'erp_return_code' => 999];
        $connection = $this->erpSyncResource->getConnection();
        $connection->insert($this->erpSyncResource->getMainTable(), $data);

        $this->moduleDataSetup->endSetup();

        return $this;
    }
}
