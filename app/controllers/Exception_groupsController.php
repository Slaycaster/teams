<?php

class Exception_groupsController extends BaseController {

	/**
	 * Exception_group Repository
	 *
	 * @var Exception_group
	 */
	protected $exception_group;

	public function __construct(Exception_group $exception_group)
	{
		$this->exception_group = $exception_group;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$exception_groups = $this->exception_group->all();

		return View::make('exception_groups.index', compact('exception_groups'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('exception_groups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Exception_group::$rules);

		if ($validation->passes())
		{
			$this->exception_group->create($input);

			return Redirect::route('exception_groups.index');
		}

		return Redirect::route('exception_groups.create')
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
		$exception_group = $this->exception_group->findOrFail($id);

		return View::make('exception_groups.show', compact('exception_group'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$exception_group = $this->exception_group->find($id);

		if (is_null($exception_group))
		{
			return Redirect::route('exception_groups.index');
		}

		return View::make('exception_groups.edit', compact('exception_group'));
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
		$validation = Validator::make($input, Exception_group::$rules);

		if ($validation->passes())
		{
			$exception_group = $this->exception_group->find($id);
			$exception_group->update($input);

			return Redirect::route('exception_policies.show', $id);
		}

		return Redirect::route('exception_groups.edit', $id)
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
		$this->exception_group->find($id)->delete();

		return Redirect::route('exception_groups.index');
	}

}
