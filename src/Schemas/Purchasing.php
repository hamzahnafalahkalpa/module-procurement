<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\Purchasing as ContractsPurchasing;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingUpdateData;

class Purchasing extends BaseModuleProcurement implements ContractsPurchasing
{
    protected string $__entity = 'Purchasing';
    public $purchasing_model;
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
        $purchasing_dto->props->props['prop_procurement'] = $purchasing->procurement->toViewApi()->resolve();
        $procurement = &$purchasing->procurement;
        $purchasing_dto->id ??= $purchasing->getKey();
        $this->updateUsingPurchaseRequests($purchasing_dto, $purchasing_dto->purchase_request_ids ?? [], $procurement)
             ->updateUsingPurchaseRequests($purchasing_dto, $purchasing_dto->purchase_requests ?? [], $procurement);
        if (isset($purchasing_dto->purchase_orders) && count($purchasing_dto->purchase_orders)){
            $procurment_dto       = &$purchasing_dto->procurement;
            $purchasing_total_tax = &$procurment_dto->props->total_tax;
            foreach ($purchasing_dto->purchase_orders as $order_dto){
                $order_dto->purchasing_id                 = $purchasing->getKey();
                if (isset($purchasing_dto->procurement->props->tax)) $order_dto->procurement->props->tax       = clone $purchasing_dto->procurement->props->tax;
                if (isset($purchasing_dto->procurement->props->total_tax)) $order_dto->procurement->props->total_tax = clone $purchasing_dto->procurement->props->total_tax;
                $order_dto->props->props['prop_purchasing'] = [
                    'id'   => $purchasing->getKey(),
                    'name' => $purchasing->name
                ];
                $po = $this->schemaContract('purchase_order')->prepareStorePurchaseOrder($order_dto);
                $po_procurement = $po->procurement;
                if (isset($purchasing_total_tax)){
                    $purchasing_total_tax->total += $po_procurement->total_tax['total'] ?? 0;
                    $purchasing_total_tax->pph   += $po_procurement->total_tax['pph'] ?? 0;
                    $purchasing_total_tax->ppn   += $po_procurement->total_tax['ppn'] ?? 0;
                }
                $procurement->total_cogs     += $po_procurement->total_tax['total'] ?? 0;
                // $total_cogs += $order_dto->cogs;
            }
        }
        $this->fillingProps($purchasing,$purchasing_dto->props);
        $this->fillingProps($purchasing->procurement,$purchasing_dto->procurement->props);
        $purchasing->procurement->save();
        $purchasing->save();
        return $this->purchasing_model = $purchasing;
    }

    protected function updateUsingPurchaseRequests(PurchasingData &$purchasing_dto, $requests, $procurement): self{
        if (isset($requests) && count($requests)){
            $prop_requests = [];
            foreach ($requests as $request) {                
                $purchase_request_model = $this->updatePurchaseRequest(is_object($request) ? $request->id : $request, $procurement, $purchasing_dto);
                $prop_requests[] = [
                    'id'               => $purchase_request_model->getKey(),
                    'name'             => $purchase_request_model->name,
                    'estimate_used_at' => $purchase_request_model->estimate_used_at
                ];
            }
            $purchasing_dto->props->props['prop_purchase_requests'] = $prop_requests;
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

    public function prepareUpdatePurchasing(PurchasingUpdateData $purchasing_dto): Model{
        $model    = $this->usingEntity()->with('purchaseOrders')->findOrFail($purchasing_dto->id);
        $approver = &$purchasing_dto->props->approval->props['approver'];
        $approver = array_merge($model->approval['approver'],$approver);
        $procurement = $model->procurement;
        if (isset($purchasing_dto->props->props['status'])){
            $procurement->status = $purchasing_dto->props->props['status'];
        }
        if (isset($purchasing_dto->reported_at)){
            $procurement->reported_at  = $purchasing_dto->reported_at;
            foreach ($model->purchaseOrders as $purchaseOrder) {
                $po_procurement              = $purchaseOrder->procurement;
                $po_procurement->reported_at = $purchasing_dto->reported_at;
                $transaction = $purchaseOrder->procurement->transaction;
                $transaction->journal_reported_at = $purchasing_dto->reported_at;
                $transaction->save();
            }
        }
        $procurement->save();
        $this->fillingProps($model,$purchasing_dto->props);
        $model->save();
        return $this->purchasing_model = $model;
    }
}