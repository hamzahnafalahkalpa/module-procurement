<?php

namespace Hanafalah\ModuleProcurement\Resources\WorkOrder;

use Hanafalah\ModuleProcurement\Resources\PurchaseOrder\ShowPurchaseOrder;

class ShowWorkOrder extends ViewWorkOrder
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
      'purchase_orders' => $this->relationValidation('purchaseOrders',function(){
        return $this->purchaseOrders->transform(function($purchaseOrder){
          return $purchaseOrder->toShowApi()->resolve();
        });
      })
    ];
    $show = $this->resolveNow(new ShowPurchaseOrder($this));
    $arr  = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
