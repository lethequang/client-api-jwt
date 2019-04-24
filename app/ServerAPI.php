<?php
/**
 * Created by PhpStorm.
 * User: TheQuang
 * Date: 4/17/2019
 * Time: 5:12 PM
 */

namespace App;
use App\Helpers\RequestAPI;

class ServerAPI
{
	/**
	 * @var RequestAPI
	 */
	public $requestApi;


	/**
	 * ServerAPI constructor.
	 * @param RequestAPI $requestAPI
	 */
    public function __construct(RequestAPI $requestAPI) {
		$this->requestApi = $requestAPI;
	}


	/**
	 * Prepare URL for request
	 * @param $path
	 * @return string
	 */
	public function requestUrl($path) {
    	return config('params.server-api') . $path ;
	}

	/*
	 * Call api login user
	 */
	public function login($params) {
    	$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/login'), $params);
    	return $response;
	}

	/*
	 * Call api get auth user
	 */
	public function getAuthInfo($token) {
    	$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/me'),false, $token);
    	return $response;
	}

	/*
	 * Call api logout user
	 */
	public function logout($token) {
		$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/logout'),false, $token);
		return $response;
	}

	/*
	 * Call api refresh token
	 */
//	public function refresh($token) {
//		$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/refresh'),false, $token);
//		return $response;
//	}

	/*
	 * Call api get list user
	 */
	public function getListUser($params, $token) {
		$response = $this->requestApi->callAPI('GET', $this->requestUrl('/user/show-all'), $params, $token);
		return $response;
	}

	/*
	 * Call api remove user
	 */
	public function removeUser($id, $token) {
		$response = $this->requestApi->callAPI('DELETE', $this->requestUrl('/user/remove/') . $id, false, $token);
		return $response;
	}

	/*
	 * Call api create user
	 */
	public function createUser($params, $token) {
		$response = $this->requestApi->callAPI('POST', $this->requestUrl('/user/create'), $params, $token);
		return $response;
	}

	/*
	 * Call api get detail user
	 */
	public function detailUser($id, $token) {
		$response = $this->requestApi->callAPI('GET', $this->requestUrl('/user/detail/') . $id, false, $token);
		return $response;
	}

	/*
	 * Call api update user
	 */
	public function editUser($id, $params, $token) {
		$response = $this->requestApi->callAPI('PUT', $this->requestUrl('/user/update/') . $id, $params, $token);
		return $response;
	}
}
