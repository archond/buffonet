<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Cache;
use Illuminate\Http\Request;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $selectedLanguage;
	public $languages;

	public function __construct(){
		$this->languages = Cache::rememberForever('languages', function() {
			return \App\Language::get();
		});

		$locale = \Request::segment(1);

		$this->selectedLanguage = $this->languages->filter(function($lang) use($locale){
			return $lang->abbr == $locale;
		})->first();

		
	}

}
