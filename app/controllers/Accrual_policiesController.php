<?php

class Accrual_policiesController extends BaseController {

	/**
	 * Accrual_policy Repository
	 *
	 * @var Accrual_policy
	 */
	protected $accrual_policy;

	public function __construct(Accrual_policy $accrual_policy)
	{
		$this->accrual_policy = $accrual_policy;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$accrual_policies = $this->accrual_policy->all();

		return View::make('accrual_policies.index', compact('accrual_policies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return View::make('accrual_policies.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Accrual_policy::$rules);

		if ($validation->passes())
		{
			$this->accrual_policy->create($input);

			return Redirect::route('accrual_policies.index');
		}

		return Redirect::route('accrual_policies.create')
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
		$accrual_policy = $this->accrual_policy->findOrFail($id);

		return View::make('accrual_policies.show', compact('accrual_policy'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$accrual_policy = $this->accrual_policy->find($id);

		if (is_null($accrual_policy))
		{
			return Redirect::route('accrual_policies.index');
		}

		return View::make('accrual_policies.edit', compact('accrual_policy'));
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
		$validation = Validator::make($input, Accrual_policy::$rules);

		if ($validation->passes())
		{
			$accrual_policy = $this->accrual_policy->find($id);
			$accrual_policy->update($input);

			return Redirect::route('accrual_policies.show', $id);
		}

		return Redirect::route('accrual_policies.edit', $id)
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
		$this->accrual_policy->find($id)->delete();

		return Redirect::route('accrual_policies.index');
	}

}
