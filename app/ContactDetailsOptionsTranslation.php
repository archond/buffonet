<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetailsOptionsTranslation extends Model
{
	protected $table = 'contactdetails_options_translation';

	protected $fillable = [
	'language_id', 'name', 'contactdetails_oprion_id'
	];

	public $timestamps = false;
}
