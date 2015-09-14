<?php

class AttendancesController extends BaseController {

	/**
	 * Attendance Repository
	 *
	 * @var Attendance
	 */
	protected $attendance;

	public function __construct(Attendance $attendance)
	{
		$this->attendance = $attendance;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$attendances = $this->attendance->all();

		return View::make('attendances.index', compact('attendances'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('attendances.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Attendance::$rules);

		if ($validation->passes())
		{
			$this->attendance->create($input);

			return Redirect::route('attendances.index');
		}

		return Redirect::route('attendances.create')
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
		$attendance = $this->attendance->findOrFail($id);

		return View::make('attendances.show', compact('attendance'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$attendance = $this->attendance->find($id);

		if (is_null($attendance))
		{
			return Redirect::route('attendances.index');
		}

		return View::make('attendances.edit', compact('attendance'));
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
		$validation = Validator::make($input, Attendance::$rules);

		if ($validation->passes())
		{
			$attendance = $this->attendance->find($id);
			$attendance->update($input);

			return Redirect::route('attendances.show', $id);
		}

		return Redirect::route('attendances.edit', $id)
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
		$this->attendance->find($id)->delete();

		return Redirect::route('attendances.index');
	}

}
