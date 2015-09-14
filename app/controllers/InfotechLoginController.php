<?php

class InfotechLoginController extends BaseController
{
	public function showLogin()
	{
		return View::make('infotechlogin');
	}

	public function doLogin()
	{
		$rules = array(
			'username'   => 'required', 
			'password'=> 'required|alphaNum|min:4'

			);


		$validator = Validator::make(Input::all(), $rules);

		if($validator -> fails()){

			return Redirect::to('login/infotech')
			->withErrors($validator)
			->withInput(Input::except('password')); 
		}
		else
		{
			$user = Input::get('username');
			$pass = Input::get('password');
			$credentials = DB::table('itechs')->where('username', '=', $user)->where('password', '=', $pass)->get();
			
			if (count($credentials) > 0) {
				foreach ($credentials as $key => $value) {
					$username = $value->username;
					$itechid = $value->id;
				}
				Session::put('itechid', $itechid);
				Session::put('username', $username);
				
				return Redirect::to('itechs/dashboard');
			}
			else
			{
				Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');
				return Redirect::to('login/infotech');
			}
		}
	}//doLogin

	public function doLogout()
	{
		Session::flush();
		Session::flash('message2', 'Successfully logged out. Have a good day!');
				return Redirect::to('login/infotech');
	}

	public function showDashboard()
	{
		if (Session::has('itechid') && Session::has('username')) {
			$id = Session::get('itechid', 'default');
			$name = Session::get('username', 'default');
			$users = DB::table('employs')->count();
			return View::make('itechs.dashboard')
				->with('id', $id)
				->with('users',$users)
				->with('name', $name);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/infotech');
		}
		
	}

	public function showIndex()
	{
		if (Session::has('itechid') && Session::has('username')) {
			$id = Session::get('itechid', 'default');
			$name = Session::get('username', 'default');
			$employs = Employ::paginate(9);
			
			return View::make('itechs.index', compact('itechs'))
				->with('employs',$employs)
				->with('id', $id)
				->with('name', $name);
				
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/infotech');
		}
		
	}

}
?>