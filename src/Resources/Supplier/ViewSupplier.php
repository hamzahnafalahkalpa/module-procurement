<?php

namespace Hanafalah\ModuleProcurement\Resources\Supplier;

use Hanafalah\ModuleOrganization\Resources\Organization\ViewOrganization;

class ViewSupplier extends ViewOrganization
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'         => $this->id,
            'name'       => $this->name,
            'supplier_code' => $this->supplier_code,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        return $arr;
    }
}
