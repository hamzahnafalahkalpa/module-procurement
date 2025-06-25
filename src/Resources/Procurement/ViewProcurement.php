<?php

namespace Hanafalah\ModuleProcurement\Resources\Procurement;

use Hanafalah\LaravelSupport\Resources\ApiResource;

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
            'id'               => $this->id,
            'procurement_code' => $this->procurement_code,
            'author'           => $this->prop_author,
            'warehouse'        => $this->prop_warehouse,
            'reported_at'      => $this->reported_at,
            'status'           => $this->status,
            'before_tax'       => $this->total_cogs ?? 0 - $this->total_tax->total ?? 0,
            'total_cogs'       => $this->total_cogs,
            'total_tax'        => $this->total_tax,
            'transaction'      => $this->relationValidation('transaction', function () {
                return $this->transaction->toViewApi();
            }),
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
        return $arr;
    }
}
