<?php

namespace Hanafalah\ModuleProcurement\Resources\Supplier;

use Hanafalah\ModuleProcurement\Resources\Procurement\ShowProcurement;

class ShowSupplier extends ViewSupplier
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'address' => $this->address,
            'procurements' => $this->relationValidation('procurements', function () {
                $procurements = $this->procurements;

                return $procurements->transform(function ($procurement) {
                    return new ShowProcurement($procurement);
                });
            }),
        ];

        $arr = $this->mergeArray(parent::toArray($request), $arr);


        return $arr;
    }
}
