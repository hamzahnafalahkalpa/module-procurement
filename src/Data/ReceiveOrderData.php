<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Concerns\ReceiveOrder\FormDataHelper;
use Hanafalah\ModuleProcurement\Contracts\Data\ReceiveOrderData as DataReceiveOrderData;
use Hanafalah\ModuleProcurement\Contracts\Data\ReceiveOrderPropsData;
use Hanafalah\ModuleWarehouse\Enums\MainMovement\Direction;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class ReceiveOrderData extends Data implements DataReceiveOrderData
{
    use FormDataHelper;

    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('procurement')]
    #[MapName('procurement')]
    public ?ProcurementData $procurement = null;

    #[MapInputName('received_at')]
    #[MapName('received_at')]
    #[DateFormat('Y-m-d')]
    public ?string $received_at;

    #[MapInputName('sender_name')]
    #[MapName('sender_name')]
    public ?string $sender_name = null;

    #[MapInputName('receipt_code')]
    #[MapName('receipt_code')]
    public ?string $receipt_code = null;

    #[MapInputName('purchasing_id')]
    #[MapName('purchasing_id')]
    public mixed $purchasing_id = null;

    #[MapInputName('purchase_order_id')]
    #[MapName('purchase_order_id')]
    public mixed $purchase_order_id;

    #[MapInputName('received_file')]
    #[MapName('received_file')]
    public string|UploadedFile|null $received_file = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?ReceiveOrderPropsData $props = null;

    public static function before(array &$attributes){
        $new = self::new();

        $procurement = &$attributes['procurement'];
        $attributes['reporting'] ??= false;
        if ($attributes['reporting']) {
            $procurement['reported_at'] ??= now();
            $procurement['is_reported'] = true;
        }

        $procurement['name'] ??= $attributes['name'];
        if (!isset($procurement)) $procurement = ['id'=>null];

        $purchase_order = $new->PurchaseOrderModel()->findOrFail($attributes['purchase_order_id']);
        $attributes['prop_purchase_order'] = $purchase_order->toViewApi()->resolve();

        $attributes['purchasing_id'] ??= $purchase_order->purchasing_id;
        $purchasing = $new->PurchasingModel()->findOrFail($attributes['purchasing_id']);
        $attributes['prop_purchasing'] = $purchasing->toViewApi()->resolve();

        $procurement['purchase_label_id'] ??= $purchasing->prop_procurement['purchase_label_id'];
        if (!isset($procurement['warehouse_id'])){
            $procurement['warehouse_id']   = $purchasing->prop_procurement['warehouse_id'];
            $procurement['warehouse_type'] = $purchasing->prop_procurement['warehouse_type'];
        }
        if (isset($attributes['form'])){
            self::prepareForm($purchase_order,$attributes);
        }else{
            self::preparing($purchase_order,$attributes);
        }
    }

    public static function after(self $data): self{
        $new = self::new();
        return $data;
    }
}