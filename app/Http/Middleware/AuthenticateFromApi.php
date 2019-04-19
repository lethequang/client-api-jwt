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
		/*
		 * Redirect to login
		 * In case: Session is not found
		 */
		if (!Session('jwt')) {
			return redirect('/');
		}

		// Get access token from session
		$token = Session('jwt')['access_token'];
		$currentAuth = $this->serverAPI->getAuthInfo($token);

		/*
		 * Remove session and re-login
		 * In case: Token invalid, Token expired,...
		 */
		if ($currentAuth['code'] === 401) {
			Session()->forget('jwt');
			return redirect('/');
		}

		// Share user auth to all views
		\View::share('user', $currentAuth['data']);

        return $next($request);
    }
}
