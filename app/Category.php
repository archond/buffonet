<?php

namespace App;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = [
	'slug', 'parent_id'
	];

	public $timestamps = true;

	public function translations(){
		return $this->hasMany(CategoryTranslation::class);
	}
	public function translation(){
		return $this->hasOne(CategoryTranslation::class)->where('language_id', (new Controller())->selectedLanguage->id );
	}

	public function parent(){
		return $this->hasOne(Category::class, 'id', 'parent_id')/*->with('translation')->with('children')*/
		->with(['translation'=>function($q){
			$q->where('language_id', (new Controller())->selectedLanguage->id );
		} ]);
	}

	// public function parents(){
	// 	return $this->hasMany(Category::class, 'id', 'parent_id');   
	// }

	public function parentChildrens(){
		return $this->parent()->with('children');
	}


	public function brothers(){
		return $this->hasMany(Category::class, 'parent_id',  'parent_id')->with(['translation'=>function($q){
			$q->where('language_id', (new Controller())->selectedLanguage->id );
		} ]);
	}

	public function parentCategory(){
		return $this->parent()->with('brothers');;
	}

	public function parentBrothersTree(){
		return $this->parentBrothers()->with('');
	}


	public function parents(){
		return $this->parent()->with('parent.children');
	}

	public function parentsParent(){
		return $this->parents()->with('parents');
	}

	public function allParent(){
		return $this->parent()->with('parent');
	}

	public function allParent1(){ 
		return $this->allParent()->with('allParent');
	}



	public function children(){
		return $this->hasMany(Category::class, 'parent_id')/*->with('translation')*/;  
	}

	public function allChildren()
	{
		return $this->children()->with('children');
	}



	public function childs(){
		return  $this->hasMany(Category::class, 'parent_id');
	}

	public function childs1(){
		return  $this->childs()->with('childs');
	}

	public function childs2(){
		return  $this->childs1()->with('childs1');
	}

	public function childs3(){
		return  $this->childs2()->with('childs2');
	}


	public function scopeTop($q){
		return $q->whereNull('parent_id')->orWhere('parent_id', 0);
	}

	public function contactValues (){
		return $this->hasMany(ContactDetailValue::class, 'value')->where('contactdetail_id', 41);
	}


}
