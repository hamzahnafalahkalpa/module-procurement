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
      'total_cogs'    => $this->total_cogs,
      'total_tax'     => $this->total_tax,
      'supplier'      => $this->prop_supplier,
      'funding'       => $this->prop_funding,
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
