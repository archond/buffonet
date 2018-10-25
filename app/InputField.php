<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputField extends Model
{
	protected $table = 'input_fields';

	protected $fillable = [
	'name'
	];

	public $timestamps = false;
}
