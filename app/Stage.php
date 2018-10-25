<?php

namespace App;

use App\Scopes\StageScope;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model {

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StageScope);
    }

    protected $table = 'stages';

    protected $fillable = [
        'name', 'order', 'is_contact_data_stage'
    ];

    public $timestamps = true;

    public function contactDetails()
    {
        return $this->hasMany(ContactDetail::class)->orderBy('order', 'asc');
    }

    public function translations()
    {
        return $this->hasMany(StageTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(StageTranslation::class);
    }
}
