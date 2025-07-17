<?php

namespace Hanafalah\ModuleProcurement\Concerns\Procurement;

use Illuminate\Database\Eloquent\Model;

trait HasProcurement
{
    public static function bootHasProcurement(){
        static::created(function($query){
            $query->procurement()->firstOrCreate();
        });
    }

    public function procurement(){
        return $this->morphOneModel('Procurement','reference');
    }

    public function setProcurementAttributes(array $attributes,? Model $procurement = null){
        $procurement ??= $this->procurement;
        foreach ($attributes as $key => $attribute) {
            $procurement->{$key} = $attribute;
        }
        $procurement->save();
    }

    public function setAuthor(array $author,? Model $procurement = null){
        $procurement ??= $this->procurement;
        $procurement->author_id   = $author['author_id'];
        $procurement->author_type = $author['author_type'];
        $procurement->save();
    }
}