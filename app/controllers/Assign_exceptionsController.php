<?php

class Assign_exceptionsController extends BaseController {

	/**
	 * Assign_exception Repository
	 *
	 * @var Assign_exception
	 */
	protected $assign_exception;

	public function __construct(Assign_exception $assign_exception)
	{
		$this->assign_exception = $assign_exception;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$assign_exceptions = $this->assign_exception->all();

		return View::make('assign_exceptions.index', compact('assign_exceptions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('assign_exceptions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Assign_exception::$rules);

		if ($validation->passes())
		{
			
			$exception = new Assign_exception;
			$exception->group_id = Input::get('group_id');
			$exception->exception_id = Input::get('exception_id');
			$exception->save();
			return Redirect::route('exception_policies.index');
		}

		return Redirect::route('exception_policies.index')
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
		$assign_exception = $this->assign_exception->findOrFail($id);

		return View::make('assign_exceptions.show', compact('assign_exception'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$assign_exception = $this->assign_exception->find($id);

		if (is_null($assign_exception))
		{
			return Redirect::route('assign_exceptions.index');
		}

		return View::make('assign_exceptions.edit', compact('assign_exception'));
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
		$validation = Validator::make($input, Assign_exception::$rules);

		if ($validation->passes())
		{
			$assign_exception = $this->assign_exception->find($id);
			$assign_exception->update($input);

			return Redirect::route('assign_exceptions.show', $id);
		}

		return Redirect::route('assign_exceptions.edit', $id)
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
		$this->assign_exception->find($id)->delete();

		return Redirect::route('assign_exceptions.index');
	}

}
