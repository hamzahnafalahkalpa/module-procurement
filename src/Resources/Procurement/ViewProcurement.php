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
        $before_tax = $this->total_cogs ?? 0;
        if (isset($this->total_tax) && isset($this->total_tax['total'])){
            $before_tax -= $this->total_tax['total'];
        }
        $arr = [
            'id'                => $this->id,
            'procurement_code'  => $this->procurement_code,
            'author'            => $this->prop_author,
            'warehouse_type'    => $this->warehouse_type,
            'warehouse_id'      => $this->warehouse_id,
            'warehouse'         => $this->prop_warehouse,
            'sender'            => $this->prop_sender,
            'reported_at'       => $this->reported_at,
            'is_reported'       => $this->is_reported ?? false,
            'approved_at'       => $this->approved_at,
            'is_approved'       => $this->is_approved ?? false,
            'status'            => $this->status,
            'before_tax'        => $before_tax,
            'total_cogs'        => $this->total_cogs,
            'total_tax'         => $this->total_tax,
            'transaction'       => $this->prop_transaction,
            'purchase_label_id' => $this->purchase_label_id,
            'purchase_label'    => $this->prop_purchase_label,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
        return $arr;
    }
}
