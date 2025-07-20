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
    public $purchase_request_model;

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
        $this->initializeProcurementDTO($purchase_request,$purchase_request_dto);
        $purchase_request_dto->props['prop_procurement'] = $purchase_request->procurement->toViewApi()->resolve();

        $this->fillingProps($purchase_request,$purchase_request_dto->props);
        $purchase_request->save();
        return $this->purchase_request_model = $purchase_request;
    }
}