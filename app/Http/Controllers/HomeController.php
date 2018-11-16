<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Gettext\Translations;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
		public function trans()
		{
				return view('trans.trans');
		}
		public function addTrans(Request $request)
		{
			$params = $request->all();


		  $translationsLV = Translations::fromPoFile('C:\var\www\buffonet\resources\lang\i18n\lv_LV\LC_MESSAGES\messages.po');
			$translationLV = $translationsLV->find(null, $params['trans']);
			// dd($translationLV);
			// $translationArr = (array) $translation;
			if($translationLV !== false){
			$translationArrLV = array();
			reset($translationLV);
			while (list($key, $val) = each($translationLV))
	    $translationArrLV[$key = ($key{0} === "\0") ? substr($key, strpos($key, "\0", 1) + 1) : $key] = $val;

			$translationsRU = Translations::fromPoFile('C:\var\www\buffonet\resources\lang\i18n\ru_RU\LC_MESSAGES\messages.po');
			$translationRU = $translationsRU->find(null, $params['trans']);
			// $translationArr = (array) $translation;
			$translationArrRU = array();
			reset($translationRU);
			while (list($key, $val) = each($translationRU))
	    $translationArrRU[$key = ($key{0} === "\0") ? substr($key, strpos($key, "\0", 1) + 1) : $key] = $val;


				return view('trans.editTrans', array(
					'original' => $params['trans'],
					'translateLV' => $translationArrLV['translation'],
					'translateRU' => $translationArrRU['translation']
				));
			}
			else {
				Session::flash('alert-danger', __('Error, this word not found'));
				// Session::flash('alert-warning', 'warning');
				// Session::flash('alert-success', 'success');
				// Session::flash('alert-info', 'info');
				return view('trans.trans');}
		}
		public function updateTrans(Request $request)
		{
			$params = $request->all();
			// dd($params);
			$params['transLV'] = isset($params['transLV']) ? (strlen($params['transLV']) == 0 ? $params['transLV'].'%' : $params['transLV']) : '%';
			// dd($params['transLV']);
			if($params['transLV']){
				 $translationsLV = Translations::fromPoFile('C:\var\www\buffonet\resources\lang\i18n\lv_LV\LC_MESSAGES\messages.po');
				 $translationLV = $translationsLV->find(null, $params['original']);
				 // dd($translationLV);
				 if ($translationLV) {
				 $translationLV->setTranslation($params['transLV']);
			   }
				 $translationsLV->toPoFile('C:\var\www\buffonet\resources\lang\i18n\lv_LV\LC_MESSAGES\messages.po');

			}
			if(($params['transRU'])){
				$translationsRU = Translations::fromPoFile('C:\var\www\buffonet\resources\lang\i18n\ru_RU\LC_MESSAGES\messages.po');
				$translationRU = $translationsRU->find(null, $params['original']);

				if ($translationRU) {
				$translationRU->setTranslation($params['transRU']);
				}
				// dd($translationsRU);
				$translationsRU->toPoFile('C:\var\www\buffonet\resources\lang\i18n\ru_RU\LC_MESSAGES\messages.po');
			}
			Session::flash('message', __('Translate update has succesfuly'));
			return view('trans.trans');

		}
}
