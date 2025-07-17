<?php

namespace Hanafalah\ModuleProcurement\Resources\Purchasing;

class ShowPurchasing extends ViewPurchasing
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
      'procurement' => $this->relationValidation('procurement',function(){
        return $this->procurement->toShowApi()->resolve();
      }),
      'purchase_requests' => $this->prop_purchase_requests,
      'purchase_orders'   => $this->relationValidation('purchaseOrders',function(){
        return $this->purchaseOrders->transform(function($purchaseOrder){
          return $purchaseOrder->toShowApi()->resolve();
        });
      }),
      'tax'               => $this->tax,
      'total_tax'         => $this->total_tax,
      'total_cogs'        => $this->total_cogs
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
