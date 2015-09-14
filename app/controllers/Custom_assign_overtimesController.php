<?php

class Custom_assign_overtimesController extends BaseController {

	/**
	 * Custom_assign_overtime Repository
	 *
	 * @var Custom_assign_overtime
	 */
	protected $custom_assign_overtime;

	public function __construct(Custom_assign_overtime $custom_assign_overtime)
	{
		$this->custom_assign_overtime = $custom_assign_overtime;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$custom_assign_overtimes = $this->custom_assign_overtime->all();

		return View::make('custom_assign_overtimes.index', compact('custom_assign_overtimes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('custom_assign_overtimes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Custom_assign_overtime::$rules);

		if ($validation->passes())
		{
			$this->custom_assign_overtime->create($input);

			return Redirect::route('custom_assign_overtimes.index');
		}

		return Redirect::route('custom_assign_overtimes.create')
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
		$custom_assign_overtime = $this->custom_assign_overtime->findOrFail($id);

		return View::make('custom_assign_overtimes.show', compact('custom_assign_overtime'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$custom_assign_overtime = $this->custom_assign_overtime->find($id);

		if (is_null($custom_assign_overtime))
		{
			return Redirect::route('custom_assign_overtimes.index');
		}

		return View::make('custom_assign_overtimes.edit', compact('custom_assign_overtime'));
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
		$validation = Validator::make($input, Custom_assign_overtime::$rules);

		if ($validation->passes())
		{
			$custom_assign_overtime = $this->custom_assign_overtime->find($id);
			$custom_assign_overtime->update($input);

			return Redirect::route('custom_assign_overtimes.show', $id);
		}

		return Redirect::route('custom_assign_overtimes.edit', $id)
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
		$this->custom_assign_overtime->find($id)->delete();

		return Redirect::route('custom_assign_overtimes.index');
	}

}
