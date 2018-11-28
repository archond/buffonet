<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Gettext\Translations;
use Xinax\LaravelGettext\Facades\LaravelGettext;
use App\User;
use Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Models\Users;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  User::paginate(config('constants.PAGINATE_PER_PAGE'));
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @return mixed
     */

    public function setAdminRole($encriptedId){

        try {
            $id =  Crypt::decrypt($encriptedId);
        } catch(\Exception $e) {
            return redirect()->route('users.index')->with('warning', true)->with('form_message', _('There is no such user in system'));
        }

        $user = User::find($id);

        if($user->is_admin == 2 ){
            $user->is_admin = 0;
        } else{
            $user->is_admin = 2;
        }
        $user->save();
				//
				// if(is_null($user->is_admin)){
				// 		$user->is_admin = 2;
				// }
        return redirect()->route('users.index')->with('success', true)->with('form_message', _('Moderator is role changed success'));
    }

		// public function showUserProfile()
  	// {
		// 	$id = Auth::user()->id;
		//
    //     return view('users.showForm');
    // }
		public function showUserContact(Request $request) {
				$page = $request->input('page');
				$id = Auth::user()->id;
				$data = Users::getContacts($id);
				return view('users.contactForm', ['data' => $data]);
	  }

	public function editUserContact(Request $request) {
		  $params = $request->all();
			Users::editContacts($request->all());
			return Redirect::to('/'.LaravelGettext::getLocaleLanguage().'/contact/');
		}


	public function showUserAddresses(Request $request) {
			$page = $request->input('page');
			$id = Auth::user()->id;
			$data = Users::getAddresses($id);
			$country = Users::getCountries();
			$cities = Users::getCities();
			// $countryArr = array();
			// foreach($country as $row) {
			// $rename = array(
			// 	'name' => $row->name,
			// 	'id' => $row->id,
			// );
			// array_push($countryArr, $rename);}
			foreach ($country as $key => $value) {
  		$countryArr[$key] = $value->name;
			}
			foreach ($cities as $key => $value) {
  		$citiesArr[$key] = $value->name;
			}
			return view('users.addressesForm', [
				'data' => $data,
				'country' => 	$countryArr,
				'cities' => 	$citiesArr
			]);
	}
	public function editUserAddresses(Request $request) {
		  $params = $request->all();
			Users::editAddresses($request->all());
			return Redirect::to('/'.LaravelGettext::getLocaleLanguage().'/addresses/');
		}
}
