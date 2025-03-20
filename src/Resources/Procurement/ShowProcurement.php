<?php

namespace Zahzah\ModuleProcurement\Resources\Procurement;

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
            'author' => $this->relationValidation('author', function () {
                return $this->author->toViewApi();
            }),
            'supplier' => $this->relationValidation('supplier', function () {
                return $this->supplier->toShowApi();
            }),
            'funding' => $this->relationValidation('funding', function () {
                return $this->funding->toShowApi();
            }),
            'card_stocks' => $this->relationValidation('cardStocks',function(){
                return $this->cardStocks->transform(function($cardStock){
                    return $cardStock->toShowApi();
                });
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);


        return $arr;
    }
}
