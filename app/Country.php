<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {



    protected $table = "countries";

    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }


    public static function storeRules()
    {
        return [
            'name' => 'required|min:2|unique:countries,name'
        ];
    }

    public static function updateRules($id = null)
    {
        return [
            'name' => 'required|min:2|unique:countries,name,'. $id.',id'
        ];
    }

}
