<?php

class Premium_policiesController extends BaseController {

	/**
	 * Premium_policy Repository
	 *
	 * @var Premium_policy
	 */
	protected $premium_policy;

	public function __construct(Premium_policy $premium_policy)
	{
		$this->premium_policy = $premium_policy;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$premium_policies = $this->premium_policy->paginate(9);

		return View::make('premium_policies.index', compact('premium_policies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('premium_policies.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Premium_policy::$rules);

		if ($validation->passes())
		{
			$this->premium_policy->create($input);

			return Redirect::route('premium_policies.index');
		}

		return Redirect::route('premium_policies.create')
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
		$premium_policy = $this->premium_policy->findOrFail($id);

		return View::make('premium_policies.show', compact('premium_policy'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$premium_policy = $this->premium_policy->find($id);

		if (is_null($premium_policy))
		{
			return Redirect::route('premium_policies.index');
		}

		return View::make('premium_policies.edit', compact('premium_policy'));
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
		$validation = Validator::make($input, Premium_policy::$rules);

		if ($validation->passes())
		{
			$premium_policy = $this->premium_policy->find($id);
			$premium_policy->update($input);

			return Redirect::route('premium_policies.show', $id);
		}

		return Redirect::route('premium_policies.edit', $id)
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
		$this->premium_policy->find($id)->delete();

		return Redirect::route('premium_policies.index');
	}

}
