<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetailValueTranslation extends Model
{
	protected $table = 'contactdetails_values_translations';

	protected $fillable = [
	'contactdetail_value_id','language_id', 'name' 
	];

	public $timestamps = true;
}
