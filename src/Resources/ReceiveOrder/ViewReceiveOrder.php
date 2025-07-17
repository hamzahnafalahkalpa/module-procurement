<?php

namespace Hanafalah\ModuleProcurement\Resources\ReceiveOrder;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewReceiveOrder extends ApiResource
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
      'id'                => $this->id, 
      'name'              => $this->name, 
      'receive_order_code' => $this->receive_order_code,
      'receipt_code'      => $this->receipt_code,
      'received_at'       => $this->received_at,
      'sender_name'       => $this->sender_name,
      'procurement'       => $this->relationValidation('procurement',function(){
        return $this->procurement->toViewApi()->resolve();
      }),
      'purchasing_id'     => $this->purchasing_id, 
      'purchase_order_id' => $this->purchase_order_id, 
      'purchase_order'    => $this->prop_purchase_order
    ];
    return $arr;
  }
}
