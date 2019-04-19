<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\ServerAPI;

class AuthenticateFromApi
{
	/**
	 * @var ServerAPI
	 */
	public $serverAPI;


	/**
	 * AuthenticateFromApi constructor.
	 * @param ServerAPI $serverAPI
	 */
	public function __construct(ServerAPI $serverAPI) {
		$this->serverAPI = $serverAPI;
	}


	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if (!Session('jwt')) {
			return redirect('/');
		}
		$token = Session('jwt')['access_token'];
		$currentAuth = $this->serverAPI->getAuthInfo($token);

		if ($currentAuth['code'] === 401) {
			Session()->forget('jwt');
			return redirect('/');
		}

		\View::share('user', $currentAuth['data']);

        return $next($request);
    }
}
