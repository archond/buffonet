<?php
namespace App\Http\Models;
use DB;
use Input;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Users extends Model {

	public static function getCountries(){
		$map = DB::table('countries');
		return $map->get([
			'name',
			'id'
		]);
	}
	public static function getCities(){
		$map = DB::table('cities');
		return $map->get([
			'name',
			'id'
		]);
	}


	public static function getContacts($id) {
		$reports = DB::table('users')
		->where('users.id','=', $id);
		return $reports->get();
	}

	public static function editContacts($params) {
		$id = Auth::user()->id;
		return DB::table('users')
		  ->where('users.id', '=', $id)
			->update([
				'users.language' 	=> $params['language'],
				'users.name' 	=> $params['name'],
				'users.email' 			=> $params['email'],
				'users.phone' 			=> $params['phone'],
				'users.updated_at' 			=> date('Y-m-d H:i:s')
			]);
	}
	public static function getAddresses($id) {
		$reports = DB::table('contacts')
		->leftjoin('addresses','contacts.id','=','addresses.contact_id')
		->join('countries','addresses.country_id','=','countries.id')
		->join('cities','addresses.city_id','=','cities.id')
		->where('contacts.id_user','=', $id);
		return $reports->get([
				'countries.name AS countryname',
				'cities.name as citiesname',
				'language_id',
				'addresses.*'
			]);
	}

	public static function editAddresses($params) {
		$id = Auth::user()->id;
		return DB::table('contacts')
		  ->where('users.id', '=', $id)
			->update([
				'users.language' 	=> $params['language'],
				'users.name' 	=> $params['name'],
				'users.email' 			=> $params['email'],
				'users.phone' 			=> $params['phone'],
				'users.updated_at' 			=> date('Y-m-d H:i:s')
			]);
	}

	// public static function addAddresses($params) {
	// 	$id = Auth::user()->id;
	// 	return DB::table('users')
	// 		->where('users.id', '=', $id)
	// 		->update([
	// 			'users.language' 	=> $params['language'],
	// 			'users.name' 	=> $params['name'],
	// 			'users.email' 			=> $params['email'],
	// 			'users.phone' 			=> $params['phone'],
	// 			'users.updated_at' 			=> date('Y-m-d H:i:s')
	// 		]);
	// }

	// public static function editItem($params) {
	// 	return DB::table('ireport')
	// 		->where('id', '=', $params['id'])
	// 		->update([
	// 			'short_name' 	=> $params['short_name'],
	// 			'full_name' 	=> $params['full_name'],
	// 			'screen' 			=> $params['screen'],
	// 			'url' 				=> $params['url'],
	// 			'sqltext' 		=> $params['sqltext'],
	// 			'prim' 				=> $params['prim'],
	// 			'dateiz' 			=> date('Y-m-d H:i:s')
	// 		]);
	// }

	// public static function delItem($id) {
	// 	return DB::table('ireport')
	// 		->where('id', '=', $id)
	// 		->delete();
	// }

}
