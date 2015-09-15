<?php

class Create_requestsController extends BaseController {

	/**
	 * Create_request Repository
	 *
	 * @var Create_request
	 */
	protected $create_request;

	public function __construct(Create_request $create_request)
	{
		$this->create_request = $create_request;
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_requests = create_request::where('employee_id', '=', $id)->get();
			$request_types = DB::table('request_types')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('create_requests.index', compact('create_requests'))
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('create_requests', $create_requests)
				->with('supervisor', $supervisor)
				->with('request_types', $request_types);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		date_default_timezone_set('Asia/Manila');
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_requests = create_request::where('employee_id', '=', $id)->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$request_types = DB::table('request_types')
			->lists('request_type', 'request_type');
			return View::make('create_requests.create')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor)
				->with('create_requests', $create_requests)
				->with('request_types', $request_types);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Create_request::$rules);

		if ($validation->passes())
		{
			$this->create_request->create($input);

			return Redirect::route('create_requests.index');
		}

		return Redirect::route('create_requests.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		date_default_timezone_set('Asia/Manila');
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_request = $this->create_request->findOrFail($id);
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$request_type = DB::table('request_types')
			->lists('request_type', 'request_type');
			return View::make('create_requests.show', compact('create_request'))
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor)
				->with('create_request', $create_request)
				->with('request_type', $request_type);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		date_default_timezone_set('Asia/Manila');
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_request = create_request::find($id);
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$request_type = DB::table('request_types')
			->lists('request_type', 'request_type');
			return View::make('create_requests.edit', compact('create_request'))
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor)
				->with('create_request', $create_request)
				->with('request_type', $request_type);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Create_request::$rules);

		if ($validation->passes())
		{
			$create_request = $this->create_request->find($id);
			$create_request->update($input);

			return Redirect::route('create_requests.show', $id);
		}

		return Redirect::route('create_requests.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->create_request->find($id)->delete();

		return Redirect::route('create_requests.index');
	}

}
