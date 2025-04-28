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
        return $this->procurement->toShowApi();
      }),
      'tax' => $this->tax,
      'total_tax' => $this->total_tax,
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
