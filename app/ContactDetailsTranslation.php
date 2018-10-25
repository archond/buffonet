<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetailsTranslation extends Model
{
	protected $table = 'contactdetails_translation';

	protected $fillable = [
	'language_id', 'name', 'contactdetail_id'
	];

	public $timestamps = true;
}
