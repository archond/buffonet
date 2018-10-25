<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestStage extends Model
{
	protected $table = 'request_stage';

	protected $fillable = [
	'stage_id', 'request_id'
	];
	public $timestamps = true;
}
