<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\Purchasing as ContractsPurchasing;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingData;

class Purchasing extends BaseModuleProcurement implements ContractsPurchasing
{
    protected string $__entity = 'Purchasing';
    public static $purchasing_model;
    protected mixed $__order_by_created_at = 'desc'; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'purchasing',
            'tags'     => ['purchasing', 'purchasing-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePurchasing(PurchasingData $purchasing_dto): Model{
        $purchasing = $this->PurchasingModel()->updateOrCreate([
                        'id' => $purchasing_dto->id ?? null
                    ], [
                        'name' => $purchasing_dto->name,
                        'note' => $purchasing_dto->note
                    ]);
        if (isset($purchasing_dto->purchase_request_ids) && count($purchasing_dto->purchase_request_ids)){
            $prop_purchasings = [];
            foreach ($purchasing_dto->purchase_request_ids as $purchase_request_id) {
                $purchase_request_model = $this->PurchaseRequestModel()->findOrFail($purchase_request_id);
                $purchase_request_model->purchasing_id = $purchase_request_model->getKey();
                $purchase_request_model->prop_purchasing = [
                    'id'   => $purchasing->getKey(),
                    'name' => $purchasing->name
                ];
                $purchase_request_model->save();

                $prop_purchasings[] = [
                    'id'               => $purchase_request_model->getKey(),
                    'name'             => $purchase_request_model->name,
                    'estimate_used_at' => $purchase_request_model->estimate_used_at
                ];
            }
            $purchasing_dto->props['prop_purchase_requests'] = $prop_purchasings;
        }else{
            $purchasing_dto->props['prop_purchase_requests'] = [];
        }
        if (isset($purchasing_dto->purchase_orders) && count($purchasing_dto->purchase_orders)){
            foreach ($purchasing_dto->purchase_orders as $order_dto){
                $order_dto->purchasing_id = $purchasing->getKey();
                $order_dto->tax           = $purchasing_dto->tax;
                $order_dto->props['prop_purchasing'] = [
                    'id'   => $purchasing->getKey(),
                    'name' => $purchasing->name
                ];
                $this->schemaContract('purchase_order')->prepareStorePurchaseOrder($order_dto);
            }
        }
        $this->fillingProps($purchasing,$purchasing_dto->props);
        $purchasing->save();
        return static::$purchasing_model = $purchasing;
    }
}