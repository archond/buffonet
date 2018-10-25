<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = [
        'name', 'language_id', 'mainobject_id', 'category_id', 'accurancy', 'quality', 'communication', 'rating_count'
    ];

    public $timestamps = true;


    public function contactDetailValues()
    {
        return $this->hasMany(ContactDetailValue::class);
    }

    

    public function contactDetailValue()
    {
        return $this->hasOne(ContactDetailValue::class);
    }

    public function mainobejects()
    {
        return $this->belongsTo(Mainobject::class, 'mainobject_id');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'contactdetails_values', 'contact_id', 'value')->where('contactdetail_id', 41)->with('parents');

    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');

    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }




}
