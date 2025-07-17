<?php

namespace Hanafalah\ModuleProcurement\Resources\ProcurementService;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewProcurementService extends ApiResource
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
      'id' => $this->id,
      'procurement_id' => $this->procurement_id,
      'service_id'     => $this->service_id,
      'service'        => $this->prop_service,
      'created_at'     => $this->created_at,
      'updated_at'     => $this->updated_at
    ];
    return $arr;
  }
}
