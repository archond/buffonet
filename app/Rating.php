<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
	use SoftDeletes;

	protected $table = 'ratings';

	protected $fillable = [
		'id','email','sent_date','complete_date', 'accurancy', 'contact_id','language_id','quality', 'communication','author_is_legal', 'author_name', 'author_phone', 'review', 'user_id'
	];

	public $timestamps = true;

	public function contact(){
		return $this->belongsTo(Contact::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function language(){
		return $this->belongsTo(Language::class);
	}
}
