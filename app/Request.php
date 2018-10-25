<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
	protected $table = 'requests';

	protected $fillable = [
	'email','contact_id', 'sent_date','complete_date' ,'ŗequest_data', 'admin_processed_date', 'is_confirmed_by_admin', 'is_denied_by_admin', 'request_id', 'message_text'
	];

	public $timestamps = true;

	public function stage(){
		return $this->belongsToMany(Stage::class)->withTimestamps(); 
	}

	public function scopeNotSent($q){
		return $q->whereNull('sent_date');
	}

	public function contact(){
		return $this->belongsTo(Contact::class);
	}

	public function contacts(){
		return $this->hasMany(Contact::class);
	}

	public function emails(){
		return $this->hasMany(ContactDetailValue::class, 'contact_id', 'contact_id')->where('contactdetail_id', 1);// id 1 = emails
	}

	public function title(){
		return $this->hasOne(ContactDetailValue::class, 'contact_id', 'contact_id')->where('contactdetail_id', 4);
		// id 4 = title
	}
}
