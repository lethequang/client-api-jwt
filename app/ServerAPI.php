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

	public function requestUrl($path) {
    	return config('params.server-api') . $path ;
	}

	public function login($params) {
    	$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/login'), $params);
    	return $response;
	}

	public function getAuthInfo($token) {
    	$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/me'),false, $token);
    	return $response;
	}

	public function logout($token) {
		$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/logout'),false, $token);
		return $response;
	}

	public function refresh($token) {
		$response = $this->requestApi->callAPI('POST', $this->requestUrl('/auth/refresh'),false, $token);
		return $response;
	}
}
