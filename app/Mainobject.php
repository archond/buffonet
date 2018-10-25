<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mainobject extends Model
{
	use SoftDeletes;

	protected $table = 'mainobjects';

	protected $fillable = [
	'phone'
	];

	public $timestamps = true;

	public function contacts(){
		return $this->hasMany(Contact::class);
	}


	static $rulesOnCreate = [
		'phone'=>'required|unique:mainobjects,phone,null,id,deleted_at,NULL'
	];




}
