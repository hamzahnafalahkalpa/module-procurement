<?php

namespace Hanafalah\ModuleProcurement\Resources\PurchaseRequest;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPurchaseRequest extends ApiResource
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
        'id'                    => $this->id, 
        'purchase_request_code' => $this->purchase_request_code,
        'name'                  => $this->name, 
        'approver'              => $this->prop_approver, 
        'estimate_used_at'      => $this->estimate_used_at, 
        'created_at'            => $this->created_at,
        'updated_at'            => $this->updated_at,
        'procurement'           => $this->relationValidation('procurement',function(){
            return $this->procurement->toViewApi()->resolve();
        })
    ];
    return $arr;
  }
}
