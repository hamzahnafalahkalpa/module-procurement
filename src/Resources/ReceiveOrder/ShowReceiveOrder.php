<?php

namespace Hanafalah\ModuleProcurement\Resources\ReceiveOrder;

class ShowReceiveOrder extends ViewReceiveOrder
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
      'purchase_order' => $this->relationValidation('purchaseOrder',function(){
        return $this->purchaseOrder->toShowApi()->resolve();
      }),
      'form'              => $this->form
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
