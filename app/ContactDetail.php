<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{ 
	public function __construct(){ 
		$this->orderBy('id', 'asc');
	}

	protected $table = 'contactdetails';

	protected $fillable = [ 
	'stage_id', 'input_field_id', 'name', 'order', 'is_translatable', 'is_collectable', 'model', 'is_uniq_value', 'is_searchable'
	];

	public $timestamps = true;

	public function inputField(){
		return $this->belongsTo(InputField::class); 
	}

	public function options(){
		return $this->hasMany(ContactDetailOption::class, 'contactdetail_id'); 
	}

	public function values(){
		return $this->hasMany(ContactDetailValue::class, 'contactdetail_id'); 
	}

	public function stage(){
		return $this->belongsTo(Stage::class);
	}

	public function translation(){
		return $this->hasOne(ContactDetailsTranslation::class, 'contactdetail_id');
	}

	public function translations(){
		return $this->hasMany(ContactDetailsTranslation::class, 'contactdetail_id');
	}

}
