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
        $this->initializeProcurementDTO($purchasing,$purchasing_dto);
        $purchasing->load('procurement');
        $procurement = $purchasing->procurement;
        $purchasing_dto->id ??= $purchasing->getKey();

        $this->updateUsingPurchaseRequestIds($purchasing_dto, $procurement)
             ->updateUsingPurchaseOrders($purchasing_dto, $procurement);
        if (isset($purchasing_dto->purchase_orders) && count($purchasing_dto->purchase_orders)){
            $purchasing_total_tax = &$purchasing_dto->procurement->props->total_tax;
            foreach ($purchasing_dto->purchase_orders as $order_dto){
                $order_dto->purchasing_id                 = $purchasing->getKey();
                $order_dto->procurement->props->tax       = clone $purchasing_dto->procurement->props->tax;
                $order_dto->procurement->props->total_tax = clone $purchasing_dto->procurement->props->total_tax;
                $order_dto->props->props['prop_purchasing'] = [
                    'id'   => $purchasing->getKey(),
                    'name' => $purchasing->name
                ];
                $po = $this->schemaContract('purchase_order')->prepareStorePurchaseOrder($order_dto);
                $procurement = $po->procurement;
                $purchasing_total_tax->total += $procurement->total_tax['total'];
                $purchasing_total_tax->pph   += $procurement->total_tax['pph'];
                $purchasing_total_tax->ppn   += $procurement->total_tax['ppn'];
                // $total_cogs += $order_dto->cogs;
            }
        }
        $this->fillingProps($purchasing,$purchasing_dto->props);
        $this->fillingProps($purchasing->procurement,$purchasing_dto->procurement->props);
        $purchasing->procurement->save();
        $purchasing->save();
        return static::$purchasing_model = $purchasing;
    }

    protected function updateUsingPurchaseOrders(PurchasingData &$purchasing_dto,$procurement): self{
        if (isset($purchasing_dto->purchase_requests) && count($purchasing_dto->purchase_requests)){
            $prop_purchasings = [];
            foreach ($purchasing_dto->purchase_requests as $purchase_request_dto) {
                $purchase_request_model = $this->updatePurchaseRequest($purchase_request_dto->id,$procurement,$purchasing_dto);

                $prop_purchasings[] = [
                    'id'               => $purchase_request_model->getKey(),
                    'name'             => $purchase_request_model->name,
                    'estimate_used_at' => $purchase_request_model->estimate_used_at
                ];
            }
            $purchasing_dto->props->props['prop_purchase_requests'] = $prop_purchasings;
        }
        return $this;
    }

    protected function updateUsingPurchaseRequestIds(PurchasingData &$purchasing_dto, $procurement): self{
        if (isset($purchasing_dto->purchase_request_ids) && count($purchasing_dto->purchase_request_ids)){
            $prop_purchasings = [];
            foreach ($purchasing_dto->purchase_request_ids as $purchase_request_id) {
                $purchase_request_model = $this->updatePurchaseRequest($purchase_request_id,$procurement,$purchasing_dto);
                $prop_purchasings[] = [
                    'id'               => $purchase_request_model->getKey(),
                    'name'             => $purchase_request_model->name,
                    'estimate_used_at' => $purchase_request_model->estimate_used_at
                ];
            }
            $purchasing_dto->props->props['prop_purchase_requests'] = $prop_purchasings;
        }
        return $this;
    }

    protected function updatePurchaseRequest(mixed $id, $procurement, $purchasing_dto): Model{
        $purchase_request_model = $this->PurchaseRequestModel()->findOrFail($id);
        $purchase_request_model->purchasing_id = $purchasing_dto->id;
        $purchase_request_model->approver_type = $procurement->author_type;
        $purchase_request_model->approver_id   = $procurement->author_id;
        $purchase_request_model->prop_purchasing = [
            'id'   => $purchasing_dto->id,
            'name' => $purchasing_dto->name
        ];
        $purchase_request_model->save();
        return $purchase_request_model;
    }
}