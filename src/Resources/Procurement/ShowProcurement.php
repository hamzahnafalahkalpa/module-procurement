<?php

namespace Hanafalah\ModuleProcurement\Resources\Procurement;

class ShowProcurement extends ViewProcurement
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'tax'   => $this->tax,
            'note'  => $this->note,
            'card_stocks' => $this->relationValidation('cardStocks', function () {
                return $this->cardStocks->transform(function ($cardStock) {
                    return $cardStock->toViewApi()->resolve();
                });
            }),
            'rab_work_lists' => $this->prop_rab_work_lists ?? []
            // 'procurement_lists' => $this->procurement_lists
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
