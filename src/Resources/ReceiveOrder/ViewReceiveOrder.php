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
    $arr = parent::toArray($request);
    return $arr;
  }
}
