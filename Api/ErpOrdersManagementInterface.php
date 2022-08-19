<?php
declare(strict_types=1);

namespace Kheyfets\ErpOrderSync\Api;

interface ErpOrdersManagementInterface
{

    /**
     * @param mixed $data
     * @return void
     */
    public function export(mixed $data): void;
}
