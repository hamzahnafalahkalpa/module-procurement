<?php

namespace Hanafalah\ModuleProcurement\Resources\Supplier;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewSupplier extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $props = $this->getOriginal()['props'] ?? [];
        $arr = [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        foreach ($props as $key => $prop) {
            $arr[$key] = $prop;
        }


        return $arr;
    }
}
