<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;

class ChangePasswordController extends Controller {
			public function __construct()
    {
        $this->middleware('auth');
    }
		public function showChangePasswordForm(){
				return view('users.changePassword');
		}
		public function changePassword(Request $request){

				if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
						// The passwords matches
						Session::flash('alert-danger', __('Error, current password do not exist'));
						return view('users.changePassword');
				}
				if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
						//Current password and new password are same
					Session::flash('alert-danger', __('Error, Current password and new password are same'));
					return view('users.changePassword');
				}

				// dd($request);
				$validatedData = $this->validate($request, [
					'current-password' => 'required',
					'new-password' => 'required|string|min:6|confirmed',
				]);
				// dd($request);
				// $validatedData = $request->validate([
				// 		'current-password' => 'required',
				// 		'new-password' => 'required|string|min:6|confirmed',
				// ]);
				//Change Password
				$user = Auth::user();
				$user->password = bcrypt($request->get('new-password'));
				$user->save();
				Session::flash('alert-success', 'Change password is successfuly');
				return view('users.changePassword');
		}
}
