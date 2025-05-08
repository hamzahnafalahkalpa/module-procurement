<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleItem\Data\CardStockData;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData as DataProcurementData;
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
    public ?int $total_cogs = 0;

    #[MapName('warehouse_type')] 
    #[MapInputName('warehouse_type')] 
    public ?string $warehouse_type = null;

    #[MapName('warehouse_id')] 
    #[MapInputName('warehouse_id')] 
    public mixed $warehouse_id = null;

    #[MapName('reported_at')] 
    #[MapInputName('reported_at')] 
    public ?string $reported_at = null;

    #[MapName('status')] 
    #[MapInputName('status')] 
    public ?string $status = null;

    #[MapName('card_stocks')] 
    #[MapInputName('card_stocks')] 
    #[DataCollectionOf(CardStockData::class)]
    public ?array $card_stocks = [];

    #[MapName('props')] 
    #[MapInputName('props')] 
    public ?array $props = null;

    public static function after(ProcurementData $data): ProcurementData{
        $new = static::new();
        $data->props['prop_reference'] = [
            'id'   => $data->reference_id ?? null,
            'type' => $data->reference_type ?? null,
            'name' => $data->name ?? null
        ];

        if (!isset($data->props['prop_reference']['name']) && isset($data->reference_id)){
            $reference = $new->{$data->reference_type.'Model'}()->findOrFail($data->reference_id);
            $data->props['prop_reference']['name'] = $reference->name;
        }

        $data->props['prop_warehouse'] = [
            'id'   => $data->warehouse_id ?? null,
            'name' => null
        ];

        if (!isset($data->props['prop_warehouse']['name']) && isset($data->warehouse_id)){
            $warehouse = $new->{$data->warehouse_type.'Model'}()->findOrFail($data->warehouse_id);
            $data->props['prop_warehouse']['name'] = $warehouse->name;
        }

        $data->props['prop_author'] = [
            'id'   => $data->author_id ?? null,
            'name' => null
        ];

        if (!isset($data->props['prop_author']['name']) && isset($data->author_id)){
            $author = $new->{$data->author_type.'Model'}()->findOrFail($data->author_id);
            $data->props['prop_author']['name'] = $author->name;
        }

        $data->props['total_cogs'] ??= 0;
        $data->props['total_tax']  ??= 0;
        $data->props['total_taxs'] ??= [
            'total' => 0,
            'ppn'   => 0,
            'pph'   => 0
        ];
        return $data;
    }
}