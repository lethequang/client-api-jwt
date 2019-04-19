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
	 * @param $data
	 * @param bool $token
	 * @return mixed
	 */
	public function callAPI($method, $url, $data, $token = false) {
		$this->setHttpHeaders($token);
		return $this->request($method, $url, $data);
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
	 * @param $data
	 * @return mixed
	 */
	public function request($method, $url, $data) {
		curl_setopt($this->handle, CURLOPT_URL, $url);
		curl_setopt($this->handle, CURLOPT_POSTFIELDS, json_encode($data));
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

}