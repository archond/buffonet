<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ContactDetailValueScope;

class ContactDetailValue extends Model
{
	
	// protected static function boot()
	// {
	// 	parent::boot();
	// 	static::addGlobalScope(new ContactDetailValueScope);
	// }

	protected $table = 'contactdetails_values';

	protected $fillable = [
	'contact_id','contactdetail_id', 'value', 'language_id'
	];

	public $timestamps = true; 


	public function contactDetail(){
		return $this->hasOne(ContactDetail::class, 'id', 'contactdetail_id'); 
	}


	public function valuesSelectedOption(){
		return $this->hasOne(ContactDetailOption::class, 'id', 'value');
	}

	public function language(){
		return $this->belongsTo(Language::class);
	}

	public function contact(){
		return $this->belongsTo(Contact::class);
	}

	public function translations(){
		return $this->hasMany(ContactDetailValueTranslation::class, 'contactdetail_value_id');
	}

	public function category(){
		return $this->HasOne(Category::class,'id', 'value');
	}





}
