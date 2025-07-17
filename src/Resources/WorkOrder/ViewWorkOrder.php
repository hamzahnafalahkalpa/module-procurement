<?php

namespace Hanafalah\ModuleProcurement\Resources\WorkOrder;

use Hanafalah\ModuleProcurement\Resources\PurchaseOrder\ViewPurchaseOrder;

class ViewWorkOrder extends ViewPurchaseOrder
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
      'work_order_code' => $this->work_order_code,
      'approval' => $this->approval
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
