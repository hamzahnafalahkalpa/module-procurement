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
    $arr = [
      'id'            => $this->id,
      'tax'           => $this->tax,
      'purchase_order_code' => $this->purchase_order_code,
      'supplier_id'   => intval($this->supplier_id),
      'supplier'      => $this->prop_supplier,
      'funding_id'    => $this->funding_id,
      'funding'       => $this->prop_funding,
      'received_address' => $this->received_address,
      'flag'          => $this->flag,
      'procurement' => $this->relationValidation('procurement',function(){
        return $this->procurement->toViewApi();
      }),
      'purchasing'    => $this->prop_purchasing,
      'receive_order' => $this->relationValidation('receiveOrder',function(){
        return $this->receiveOrder->toViewApi();
      })
    ];
    return $arr;
  }
}
