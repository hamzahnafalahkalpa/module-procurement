<?php

namespace Hanafalah\ModuleProcurement\Resources\Purchasing;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPurchasing extends ApiResource
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
      'id'          => $this->id,
      'purchasing_code' => $this->purchasing_code,
      'name'        => $this->name,
      'note'        => $this->note,
      'approval'    => $this->approval,
      'procurement' => $this->relationValidation('procurement',function(){
        return $this->procurement->toViewApi()->resolve();
      })
    ];
    return $arr;
  }
}
