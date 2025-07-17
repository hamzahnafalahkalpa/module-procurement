<?php

namespace Hanafalah\ModuleProcurement\Resources\PurchaseOrder;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPurchaseOrder extends ApiResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $supplier_id = $this->supplier_id ?? $this->sub_contractor_id;
    $arr = [
      'id'                  => $this->id,
      'name'                => $this->name,
      'tax'                 => $this->tax,
      'purchase_order_code' => $this->purchase_order_code,
      'supplier_id'         => isset($supplier_id) ? $supplier_id : null,
      'supplier'            => $this->supplier_type == 'SubContractor' ? $this->prop_sub_contractor : $this->prop_supplier,
      'funding_id'          => $this->funding_id,
      'funding'             => $this->prop_funding,
      'received_address'    => $this->received_address,
      'phone'               => $this->phone,
      'flag'                => $this->flag,
      'procurement'         => $this->relationValidation('procurement',function(){
        return $this->procurement->toViewApi()->resolve();
      }),
      'purchasing'    => $this->prop_purchasing,
      'receive_order' => $this->relationValidation('receiveOrder',function(){
        return $this->receiveOrder->toViewApi()->resolve();
      })
    ];
    return $arr;
  }
}