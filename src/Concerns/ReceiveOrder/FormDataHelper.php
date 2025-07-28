<?php

namespace Hanafalah\ModuleProcurement\Concerns\ReceiveOrder;

use Hanafalah\ModuleWarehouse\Enums\MainMovement\Direction;

trait FormDataHelper
{
    public static function preparing($purchase_order, array &$attributes){
        $new = self::new();
        $procurement = &$attributes['procurement'];
        foreach ($procurement['card_stocks'] as &$card_stock) {
            if (isset($card_stock['id'])) {
                $card_stock_ro = $new->CardStockModel()->with('parent')->findOrFail($card_stock['id']);
                $card_stock_model = $card_stock_ro->parent;
            }else{
                $card_stock_model = $new->CardStockModel()->findOrFail($card_stock['parent_id']);
                $card_stock['item_id'] = $card_stock_model->item_id;
            }
            $card_stock['receive_qty'] = floatval($card_stock['receive_qty'] ?? 0);
            $stock_movement = &$card_stock['stock_movement'];
            $stock_movement['direction']      = Direction::IN->value;
            $stock_movement['cogs']           = floatval($card_stock['cogs'] ?? 0);
            $stock_movement['qty']            = $card_stock['receive_qty'];
            $stock_movement['reference_type'] = $procurement['warehouse_type'];
            $stock_movement['reference_id']   = $procurement['warehouse_id'];
            // if (isset($procurement['reported_at'])){
                $stock_movement['item_stock'] = [
                    'id'             => null,
                    'funding_id'     => $purchase_order->funding_id,
                    'supplier_type'  => $purchase_order->supplier_type,
                    'supplier_id'    => $purchase_order->supplier_id,
                    'procurement_id' => $procurement['id'] ?? null,
                    'procurement_type' => 'Procurement',
                    'subject_type'   => 'Item',
                    'subject_id'     => $card_stock_model->item_id,
                    'warehouse_type' => $procurement['warehouse_type'],
                    'warehouse_id'   => $procurement['warehouse_id'],
                    'stock'          => $stock_movement['receive_qty']
                ];
            // }
        }
    }

    public static function prepareForm($purchase_order, array &$attributes){
        $new = self::new();

        $form = &$attributes['form'];
        $attributes['purchase_order_id'] ??= $form['id'];
        $procurement = &$attributes['procurement'];
        $procurement['card_stocks'] ??= [];
        $ro_card_stocks = &$procurement['card_stocks'];
        foreach ($form['procurement']['card_stocks'] as &$card_stock) {
            $card_stock_model = $new->CardStockModel()->findOrFail($card_stock['id']);
            if (isset($procurement['id'])){
                $card_stock_ro    = $new->CardStockModel()->with([
                                        'stockMovement' => function($query){
                                            $query->where('direction',Direction::IN->value);
                                        }
                                    ])
                                    ->parentId($card_stock_model->getKey())
                                    ->where('reference_type','Procurement')
                                    ->where('reference_id',$procurement['id'])
                                    ->where('item_id',$card_stock_model->item_id)->first();
            }
            $card_stock['receive_qty'] = floatval($card_stock['receive_qty']);
            $ro_card_stock = [
                'id'          => $card_stock_ro->id ?? null,
                'parent_id'   => $card_stock['id'],
                'item_id'     => $card_stock_model->item_id,
                'receive_qty' => $card_stock['receive_qty'],
                'stock_movement' => [
                    'id'             => $card_stock_ro?->stockMovement->id ?? null,
                    'direction'      => Direction::IN->value,
                    'cogs'           => floatval($card_stock['cogs'] ?? 0),
                    'qty'            => $card_stock['receive_qty'],
                    'reference_type' => $procurement['warehouse_type'],
                    'reference_id'   => $procurement['warehouse_id']
                ]
            ];
            if (isset($procurement['reported_at'])){
                $ro_card_stock['stock_movement']['item_stock'] = [
                    'id'             => null,
                    'funding_id'     => $purchase_order->funding_id,
                    'supplier_type'  => $purchase_order->supplier_type,
                    'supplier_id'    => $purchase_order->supplier_id,
                    'procurement_id' => $procurement['id'],
                    'procurement_type' => 'Procurement',
                    'subject_type'   => 'Item',
                    'subject_id'     => $card_stock_model->item_id,
                    'warehouse_type' => $procurement['warehouse_type'],
                    'warehouse_id'   => $procurement['warehouse_id'],
                    'stock'          => $card_stock['receive_qty']
                ];
            }
            $ro_card_stocks[] = $ro_card_stock;

            $card_stock['receive_qty'] = ($card_stock_model->receive_qty ?? 0) + $card_stock['receive_qty'];
            $card_stock['item']        = [
                'id'   => $card_stock_model->prop_item['id'],
                'name' => $card_stock_model->prop_item['name'],
                'unit' => $card_stock_model->prop_item['unit']
            ];
        }
    }
}