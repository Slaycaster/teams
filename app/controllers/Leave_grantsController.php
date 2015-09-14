<?php

class Leave_grantsController extends BaseController {

	/**
	 * Leave_grant Repository
	 *
	 * @var Leave_grant
	 */
	protected $leave_grant;

	public function __construct(Leave_grant $leave_grant)
	{
		$this->leave_grant = $leave_grant;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$leave_grants = $this->leave_grant->all();

		return View::make('leave_grants.index', compact('leave_grants'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('leave_grants.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Leave_grant::$rules);

		if ($validation->passes())
		{
			$this->leave_grant->create($input);

			return Redirect::route('leave_grants.index');
		}

		return Redirect::route('leave_grants.index')
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
		$leave_grant = $this->leave_grant->findOrFail($id);

		return View::make('leave_grants.show', compact('leave_grant'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$leave_grant = $this->leave_grant->find($id);

		if (is_null($leave_grant))
		{
			return Redirect::route('leave_grants.index');
		}

		return View::make('leave_grants.edit', compact('leave_grant'));
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
		$validation = Validator::make($input, Leave_grant::$rules);

		if ($validation->passes())
		{
			$leave_grant = $this->leave_grant->find($id);
			$leave_grant->update($input);

			return Redirect::route('leave_grants.index', $id);
		}

		return Redirect::route('leave_grants.edit', $id)
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
		$this->leave_grant->find($id)->delete();

		return Redirect::route('leave_grants.index');
	}

}
