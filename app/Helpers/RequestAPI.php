<?php
/**
 * Created by PhpStorm.
 * User: TheQuang
 * Date: 4/17/2019
 * Time: 5:12 PM
 */

namespace App\Helpers;

class RequestAPI
{
	/**
	 * @var resource
	 */
	protected $handle;

	/**
	 * @var array
	 */
	protected $httpHeaders = array(
		'Accept: application/json; charset:utf8;',
		'Content-type: application/json; charset:utf8'
	);


	/**
	 * RequestAPI constructor.
	 */
	public function __construct() {
		$this->handle = curl_init();
		curl_setopt($this->handle, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, TRUE);
	}


	/**
	 * @param $method
	 * @param $url
	 * @param $params
	 * @param bool $token
	 * @return mixed
	 */
	public function callAPI($method, $url, $params, $token = false) {
		$this->setHttpHeaders($token);
		return $this->request($method, $url, $params);
	}


	/**
	 * @param $token
	 */
	public function setHttpHeaders($token) {
		if ($token) {
			$this->httpHeaders[] = 'Authorization: Bearer ' . $token;
		}
		curl_setopt($this->handle, CURLOPT_HTTPHEADER, $this->httpHeaders);
	}


	/**
	 * @param $method
	 * @param $url
	 * @param $params
	 * @return mixed
	 */
	public function request($method, $url, $params) {
		curl_setopt($this->handle, CURLOPT_URL, $url);
		curl_setopt($this->handle, CURLOPT_POSTFIELDS, $this->formatParams($params));
		curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, $method);

		$response = curl_exec($this->handle);

		if (!$response) {
			$httpCode = curl_getinfo($this->handle, CURLINFO_HTTP_CODE);
			$error = curl_error($this->handle);
			die($httpCode .'-'. $error);
		}

		curl_close($this->handle);

		return $this->formatResult($response);
	}


	/**
	 * @param $res
	 * @return mixed
	 */
	public function formatResult($res) {
		return json_decode($res, TRUE);
	}


	/**
	 * @param $req
	 * @return string
	 */
	public function formatParams($req) {
		return json_encode($req);
	}

}