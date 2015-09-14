<?php

class Credit_policiesController extends BaseController {

	/**
	 * Credit_policy Repository
	 *
	 * @var Credit_policy
	 */
	protected $credit_policy;

	public function __construct(Credit_policy $credit_policy)
	{
		$this->credit_policy = $credit_policy;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$credit_policies= Credit_policy::paginate(9);

		return View::make('credit_policies.index', compact('credit_policies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$leave_type = Input::get('leave_type');
		$able = Input::get('able');
		return View::make('credit_policies.index')
		->with('leave_type', $leave_type)
		->with('able', $able);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$validation = Validator::make($input, Credit_policy::$rules);

		if ($validation->passes())
		{
			$this->credit_policy->create($input);

			return Redirect::route('credit_policies.index');
		}

		return Redirect::route('credit_policies.index')
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
		$credit_policy = $this->credit_policy->findOrFail($id);

		return View::make('credit_policies.show', compact('credit_policy'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$credit_policy = $this->credit_policy->find($id);

		if (is_null($credit_policy))
		{
			return Redirect::route('credit_policies.index');
		}

		return View::make('credit_policies.edit', compact('credit_policy'));
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
		$validation = Validator::make($input, Credit_policy::$rules);

		if ($validation->passes())
		{
			$credit_policy = $this->credit_policy->find($id);
			$credit_policy->update($input);

			return Redirect::route('credit_policies.index', $id);
		}

		return Redirect::route('credit_policies.edit', $id)
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
		$this->credit_policy->find($id)->delete();

		return Redirect::route('credit_policies.index');
	}

}
