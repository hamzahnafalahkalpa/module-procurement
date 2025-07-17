<?php

namespace Hanafalah\ModuleProcurement\Resources\Supplier;

class ShowSupplier extends ViewSupplier
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
