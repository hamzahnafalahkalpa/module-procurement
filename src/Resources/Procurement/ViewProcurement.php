<?php

namespace Hanafalah\ModuleProcurement\Resources\Procurement;

use Hanafalah\LaravelSupport\Resources\ApiResource;
use Hanafalah\ModuleTransaction\Resources\Transaction\ViewTransaction;

class ViewProcurement extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id' => $this->id,
            'funding_id' => $this->funding_id,
            'supplier_id' => $this->supplier_id,
            'author' => $this->relationValidation('author', function () {
                return $this->author->toViewApi();
            }),
            'warehouse' => $this->relationValidation('warehouse', function () {
                return $this->warehouse->toViewApi();
            }),
            'procurement_code' => $this->procurement_code,
            'transaction' => $this->relationValidation('transaction', function () {
                return $this->transaction->toViewApi();
            }),
            'funding' => $this->relationValidation('funding', function () {
                return $this->funding->toViewApi();
            }),
            'supplier' => $this->relationValidation('supplier', function () {
                return $this->supplier->toViewApi();
            }),
            'reported_at' => $this->reported_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];


        return $arr;
    }
}
