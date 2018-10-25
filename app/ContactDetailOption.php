<?php

namespace App;


use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class ContactDetailOption extends Model
{
	protected $table = 'contactdetails_options';

	protected $fillable = [
	'contactdetail_id', 'name' 
	];

	public $timestamps = true;

	public function translation(){
//		return $this->hasOne(ContactDetailsOptionsTranslation::class, 'contactdetails_option_id');
		return $this->hasOne(ContactDetailsOptionsTranslation::class, 'contactdetails_option_id')->where('language_id', (new Controller() )->selectedLanguage->id );
	}

	public function translations(){
		return $this->hasMany(ContactDetailsOptionsTranslation::class, 'contactdetails_option_id');
	}
}
