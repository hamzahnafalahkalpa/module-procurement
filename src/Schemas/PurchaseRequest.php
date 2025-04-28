<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\PurchaseRequest as ContractsPurchaseRequest;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseRequestData;

class PurchaseRequest extends BaseModuleProcurement implements ContractsPurchaseRequest
{
    protected string $__entity = 'PurchaseRequest';
    public static $purchase_request_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'purchase_request',
            'tags'     => ['purchase_request', 'purchase_request-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePurchaseRequest(PurchaseRequestData $purchase_request_dto): Model{
        $purchase_request = $this->PurchaseRequestModel()->updateOrCreate([
                        'id' => $purchase_request_dto->id ?? null
                    ], [
                        'name'             => $purchase_request_dto->name,
                        'approver_type'    => $purchase_request_dto->approver_type,
                        'approver_id'      => $purchase_request_dto->approver_id,
                        'estimate_used_at' => $purchase_request_dto->estimate_used_at
                    ]);
        $purchase_request->load('procurement');
        $procurement                     = $purchase_request->procurement;
        $procurement_dto                 = &$purchase_request_dto->procurement;
        $procurement_dto->id             = $procurement->getKey();
        $procurement_dto->reference_type = $procurement->reference_type;
        $procurement_dto->reference_id   = $procurement->reference_id;
        $procurement_dto->status       ??= $procurement->status;

        $this->schemaContract('procurement')->prepareStoreProcurement($purchase_request_dto->procurement);
        $this->fillingProps($purchase_request,$purchase_request_dto->props);
        $purchase_request->save();
        return static::$purchase_request_model = $purchase_request;
    }
}