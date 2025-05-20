<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ApprovalData as DataApprovalData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Illuminate\Support\Str;

class ApprovalData extends Data implements DataApprovalData{
    #[MapName('note')] 
    #[MapInputName('note')] 
    public ?string $note = null;

    #[MapName('status')] 
    #[MapInputName('status')] 
    public ?string $status = null;

    #[MapName('props')] 
    #[MapInputName('props')] 
    public ?array $props = null;

    public static function after(ApprovalData $data): ApprovalData{
        $props = &$data->props;
        $new   = static::new();
        $model_name = config('module-procurement.approval');
        if (isset($model_name)){
            foreach ($props as $key => $prop) {
                if (Str::endsWith($key, '_id')){
                    $name = Str::replace('_id','',$key);
                    if (!isset($props[$name])){
                        if (isset($prop)) $model = $new->{$model_name.'Model'}()->findOrFail($prop);
                        
                        $props[$name] = [
                            'id'     => $prop,
                            'status' => null,
                            'name'   => $model->name ?? null,
                            'at'     => $model->at ?? null
                        ];
                    }
                }
            }
        }
        return $data;
    }
}