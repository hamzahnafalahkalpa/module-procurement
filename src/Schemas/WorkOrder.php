<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\WorkOrder as ContractsWorkOrder;
use Hanafalah\ModuleProcurement\Contracts\Data\WorkOrderData;

class WorkOrder extends BaseModuleProcurement implements ContractsWorkOrder
{
    protected string $__entity = 'WorkOrder';
    public static $work_order_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'work_order',
            'tags'     => ['work_order', 'work_order-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreWorkOrder(WorkOrderData $work_order_dto): Model{
        $work_order = $this->usingEntity()->updateOrCreate([
                        'id' => $work_order_dto->id ?? null
                    ], [
                        'name' => $work_order_dto->name
                    ]);
        $this->fillingProps($work_order,$work_order_dto->props);
        $work_order->save();
        return static::$work_order_model = $work_order;
    }
}