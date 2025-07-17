<?php

namespace Hanafalah\ModuleProcurement\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseRequestData as DataPurchaseRequestData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class PurchaseRequestData extends Data implements DataPurchaseRequestData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;
    
    #[MapInputName('purchase_label_id')]
    #[MapName('purchase_label_id')]
    public mixed $purchase_label_id = null;

    #[MapInputName('procurement')]
    #[MapName('procurement')]
    public ?ProcurementData $procurement = null;

    #[MapInputName('approver_type')]
    #[MapName('approver_type')]
    public ?string $approver_type = null;

    #[MapInputName('approver_id')]
    #[MapName('approver_id')]
    public mixed $approver_id = null;

    #[MapInputName('estimate_used_at')]
    #[MapName('estimate_used_at')]
    #[DateFormat('Y-m-d')]
    public ?string $estimate_used_at = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $procurement = &$attributes['procurement'];
        $attributes['reporting'] ??= false;
        if ($attributes['reporting']) {
            $procurement['reported_at'] ??= now();
            $procurement['is_reported'] = true;
        }
    }

    public static function after(PurchaseRequestData $data): PurchaseRequestData{
        $new = static::new();
        
        $data->props['prop_approver'] = [
            'id'   => $data->approver_id ?? null,
            'name' => null
        ];

        if (isset($data->props['prop_approver']['id'],$data->approver_type) && !isset($data->props['prop_approver']['name'])){
            $reference = self::new()->{$data->approver_type.'Model'}()->findOrFail($data->props['prop_approver']['id']);
            $data->props['prop_approver']['name'] = $reference->name;
        }
        
        return $data;
    }
}