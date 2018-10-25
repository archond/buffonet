<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';

	protected $fillable = [
	'name', 'language_id' 
	];

	public $timestamps = true;

	public function contacts()
	{
		return $this->morphedByMany(Contact::class, 'taggable');
	}

}
