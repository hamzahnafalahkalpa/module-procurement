<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\ProcurementList as ContractsProcurementList;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementListData;

class ProcurementList extends BaseModuleProcurement implements ContractsProcurementList
{
    protected string $__entity = 'ProcurementList';
    public $procurement_list_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'procurement_list',
            'tags'     => ['procurement_list', 'procurement_list-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreProcurementList(ProcurementListData $procurement_list_dto): Model{
        $procurement_list = $this->usingEntity()->updateOrCreate([
                        'id' => $procurement_list_dto->id ?? null
                    ], [
                        'name' => $procurement_list_dto->name
                    ]);
        $this->fillingProps($procurement_list,$procurement_list_dto->props);
        $procurement_list->save();
        return $this->procurement_list_model = $procurement_list;
    }
}