<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StageTranslation extends Model
{
    protected $table = 'stages_translation';
    protected $fillable = ['stage_id', 'language_id','name'];
}
