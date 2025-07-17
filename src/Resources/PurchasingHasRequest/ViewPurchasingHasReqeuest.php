<?php

namespace Hanafalah\ModuleProcurement\Resources\PurchasingHasRequest;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPurchasingHasRequest extends ApiResource
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
      'id'               => $this->id,
      'purchasing'       => $this->prop_purchasing,
      'purchase_request' => $this->prop_purchase_request
    ];
    return $arr;
  }
}
