<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServerAPI;
use Session;

class UserController extends Controller
{
	/**
	 * @var ServerAPI
	 */
	public $serverAPI;


	/**
	 * UserController constructor.
	 * @param ServerAPI $serverAPI
	 */
	public function __construct(ServerAPI $serverAPI) {
		$this->serverAPI = $serverAPI;
	}

	/*
	 * Show list user
	 */
	public function showAll() {
		return view('user.show-all');
	}

	/*
	 * List user ajax
	 */
	public function ajaxData(Request $request) {
		$token = Session('jwt')['access_token'];
		$result = $this->serverAPI->getListUser($request->all(), $token);
		return response()->json($result['data']);
	}

	/*
	 * Delete user
	 */
	public function destroy($id) {
		$token = Session('jwt')['access_token'];
		$result = $this->serverAPI->removeUser($id, $token);

		if ($result['code'] !== 200) {
			return response()->json([
				'status' => false,
				'msg' => 'fail delete'
			]);
		}

		return response()->json([
			'status' => true,
			'msg' => 'delete success'
		]);
	}

	/*
	 * Show create user
	 */
	public function create() {
		return view('user.create');
	}

	/*
	 * Create a user
	 */
	public function store(Request $request) {
		$token = Session('jwt')['access_token'];
		$result = $this->serverAPI->createUser($request->all(), $token);
		if ($result['code'] !== 200) {
			if ($result['code'] === 422) {
				return redirect()->back()
					->withErrors($result['errors'])
					->with('status', 'validate error');
			}
			return redirect()->back()
				->with('status', 'Create fail');
		}
		return redirect()->route('user.show-all')->with('status', 'Create successfully');
	}

	/*
	 * Show detail user to edit
	 */
	public function edit($id) {
		$token = Session('jwt')['access_token'];
		$result = $this->serverAPI->detailUser($id, $token);
		if ($result['code'] !== 200) {
			return redirect()->back()
				->with('status','User not found');
		}
		return view('user.edit', ['user' => $result['data']]);
	}

	/*
	 * Update user after edit
	 */
	public function update(Request $request, $id) {
		$token = Session('jwt')['access_token'];
		$result = $this->serverAPI->editUser($id, $request->all(), $token);
		if ($result['code'] !== 200) {
			if ($result['code'] === 422) {
				return redirect()->back()
					->withErrors($result['errors'])
					->with('status', 'Update fail');
			}
			return redirect()->back()
				->with('status', 'Update fail');
		}
		return redirect()->route('user.show-all')->with('status','Update success');
	}
}
