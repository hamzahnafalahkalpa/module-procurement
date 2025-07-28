<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleItem\Data\CardStockData;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData as DataProcurementData;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementPropsData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ProcurementData extends Data implements DataProcurementData{
    #[MapName('id')] 
    #[MapInputName('id')] 
    public mixed $id = null;

    #[MapName('name')] 
    #[MapInputName('name')] 
    public ?string $name = null;

    #[MapName('purchase_label_id')] 
    #[MapInputName('purchase_label_id')] 
    public mixed $purchase_label_id = null;

    #[MapName('reference_type')] 
    #[MapInputName('reference_type')] 
    public ?string $reference_type = null;

    #[MapName('reference_id')] 
    #[MapInputName('reference_id')] 
    public mixed $reference_id = null;

    #[MapName('author_type')] 
    #[MapInputName('author_type')] 
    public ?string $author_type = null;

    #[MapName('author_id')] 
    #[MapInputName('author_id')] 
    public mixed $author_id = null;

    #[MapName('total_cogs')] 
    #[MapInputName('total_cogs')] 
    public ?float $total_cogs = null;

    #[MapName('warehouse_type')] 
    #[MapInputName('warehouse_type')] 
    public ?string $warehouse_type = null;

    #[MapName('warehouse_id')] 
    #[MapInputName('warehouse_id')] 
    public mixed $warehouse_id = null;

    #[MapName('sender_type')] 
    #[MapInputName('sender_type')] 
    public ?string $sender_type = null;

    #[MapName('sender_id')] 
    #[MapInputName('sender_id')] 
    public mixed $sender_id = null;

    #[MapName('reported_at')] 
    #[MapInputName('reported_at')] 
    public ?string $reported_at = null;

    #[MapName('approved_at')] 
    #[MapInputName('approved_at')] 
    public ?string $approved_at = null;

    #[MapName('transaction')] 
    #[MapInputName('transaction')] 
    public ?array $transaction = null;

    #[MapName('status')] 
    #[MapInputName('status')] 
    public ?string $status = null;

    #[MapName('card_stocks')] 
    #[MapInputName('card_stocks')] 
    #[DataCollectionOf(CardStockData::class)]
    public ?array $card_stocks = [];

    #[MapName('procurement_services')] 
    #[MapInputName('procurement_services')] 
    #[DataCollectionOf(CardStockData::class)]
    public ?array $procurement_services = [];

    #[MapName('props')] 
    #[MapInputName('props')] 
    public ?ProcurementPropsData $props = null;

    public static function after(ProcurementData $data): ProcurementData{
        $new   = static::new();
        $props = &$data->props->props;

        if (isset($data->reference_type)){
            $reference = $new->{$data->reference_type.'Model'}();
            if (isset($data->reference_id)) $reference = $reference->findOrFail($data->reference_id);
            $props['prop_reference'] = $reference->toViewApi()->resolve();
        }

        $data->warehouse_type ??= config('module-procurement.warehouse');
        if (isset($data->warehouse_type)){
            $warehouse = $new->{$data->warehouse_type.'Model'}();
            if (isset($data->warehouse_id)) $warehouse = $warehouse->findOrFail($data->warehouse_id);
            $props['prop_warehouse'] = $warehouse->toViewApi()->resolve();
        }

        $data->author_type ??= config('module-procurement.author');
        if (isset($data->author_type)){
            $author = $new->{$data->author_type.'Model'}();
            if (isset($data->author_id)) $author = $author->findOrFail($data->author_id);
            $props['prop_author'] = $author->toViewApi()->only(['id','name']);
        }
        $purchase_label = $new->PurchaseLabelModel();
        if (isset($data->purchase_label_id)) $purchase_label = $purchase_label->findOrFail($data->purchase_label_id);
        $props['prop_purchase_label'] = $purchase_label->toViewApi()->only(['id','name','flag','label']);
        return $data;
    }
}