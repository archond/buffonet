<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
	protected $table = 'category_translations';

	protected $fillable = [
	'name', 'language_id', 'category_id'
	];

	public $timestamps = true;

	public function category(){
		return $this->belongsTo(Category::class);
	}

}
