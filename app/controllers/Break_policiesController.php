<?php

class Break_policiesController extends BaseController {

	/**
	 * Break_policy Repository
	 *
	 * @var Break_policy
	 */
	protected $break_policy;

	public function __construct(Break_policy $break_policy)
	{
		$this->break_policy = $break_policy;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$break_policies = $this->break_policy->all();

		return View::make('break_policies.index', compact('break_policies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('break_policies.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Break_policy::$rules);

		if ($validation->passes())
		{
			$this->break_policy->create($input);

			return Redirect::route('break_policies.index');
		}

		return Redirect::route('break_policies.create')
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
		$break_policy = $this->break_policy->findOrFail($id);

		return View::make('break_policies.show', compact('break_policy'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$break_policy = $this->break_policy->find($id);

		if (is_null($break_policy))
		{
			return Redirect::route('break_policies.index');
		}

		return View::make('break_policies.edit', compact('break_policy'));
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
		$validation = Validator::make($input, Break_policy::$rules);

		if ($validation->passes())
		{
			$break_policy = $this->break_policy->find($id);
			$break_policy->update($input);

			return Redirect::route('break_policies.show', $id);
		}

		return Redirect::route('break_policies.edit', $id)
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
		$this->break_policy->find($id)->delete();

		return Redirect::route('break_policies.index');
	}

}
