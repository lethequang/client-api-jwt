<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServerAPI;
use Session;

class AuthController extends Controller
{
	/**
	 * @var
	 */
	public $serverAPI;


	/**
	 * LoginController constructor.
	 * @param ServerAPI $serverAPI
	 */
    public function __construct(ServerAPI $serverAPI) {
		$this->serverAPI = $serverAPI;
	}

	public function getLogin() {
    	if (Session('jwt')) {
    		return redirect('/home');
		}
		return view('auth.login');
	}

	public function postLogin(Request $request) {

		$params = $request->all();

		$result = $this->serverAPI->login($params);

		if ($result['code'] !== 200) {
			if ($result['code'] === 422) {
				return redirect()->back()
					->withErrors($result['errors'])
					->with('status', 'Login fail');
			}
			return redirect()->back()
				->with('status', 'Email or password is incorrect');
		}

		$request->session()->put('jwt', $result['data']);

		return redirect('/home')->with('status', 'Login successfully');
	}


	public function getProfile() {
//		$token = Session('jwt')['access_token'];
//		$result = $this->serverAPI->getAuthInfo($token);
//		if (!$result) {
//			return redirect()->back()->with('status', 'Something error');
//		}
//		$user = $result['data'];
//		return view('auth.profile', ['user' => $user]);
		return view('auth.profile');
	}

	public function logout() {
		$token = Session('jwt')['access_token'];
		$this->serverAPI->logout($token);
		Session()->forget('jwt');
		return redirect('/login')->with('status', 'Logout successfully');
	}

	public function getHome() {
		return view('auth.home');
	}
}

