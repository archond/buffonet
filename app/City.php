<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

    protected $fillable = ['name', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    static $storeRules =  ['name'=>'required|min:2'];
    static $updateRules =  ['name'=>'required|min:2'];
}
