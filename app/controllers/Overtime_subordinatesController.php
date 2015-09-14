<?php

class Overtime_subordinatesController extends BaseController {

	/**
	 * Overtime_subordinate Repository
	 *
	 * @var Overtime_subordinate
	 */
	protected $overtime_subordinate;

	public function __construct(Overtime_subordinate $overtime_subordinate)
	{
		$this->overtime_subordinate = $overtime_subordinate;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$overtime_subordinates = $this->overtime_subordinate->all();

		return View::make('overtime_subordinates.index', compact('overtime_subordinates'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('overtime_subordinates.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Overtime_subordinate::$rules);

		if ($validation->passes())
		{
			$this->overtime_subordinate->create($input);

			return Redirect::route('overtime_subordinates.index');
		}

		return Redirect::route('overtime_subordinates.create')
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
		$overtime_subordinate = $this->overtime_subordinate->findOrFail($id);

		return View::make('overtime_subordinates.show', compact('overtime_subordinate'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$overtime_subordinate = $this->overtime_subordinate->find($id);

		if (is_null($overtime_subordinate))
		{
			return Redirect::route('overtime_subordinates.index');
		}

		return View::make('overtime_subordinates.edit', compact('overtime_subordinate'));
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
		$validation = Validator::make($input, Overtime_subordinate::$rules);

		if ($validation->passes())
		{
			$overtime_subordinate = $this->overtime_subordinate->find($id);
			$overtime_subordinate->update($input);

			return Redirect::route('overtime_subordinates.show', $id);
		}

		return Redirect::route('overtime_subordinates.edit', $id)
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
		$this->overtime_subordinate->find($id)->delete();

		return Redirect::route('overtime_subordinates.index');
	}

}
