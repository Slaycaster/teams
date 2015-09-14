<?php
 
class Overtime_policiesController extends BaseController {

	/**
	 * Overtime_policy Repository
	 *
	 * @var Overtime_policy
	 */
	protected $overtime_policy;

	public function __construct(Overtime_policy $overtime_policy)
	{
		$this->overtime_policy = $overtime_policy;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$overtime_policies = $this->overtime_policy->all();

		return View::make('overtime_policies.index', compact('overtime_policies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('overtime_policies.index');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Overtime_policy::$rules);

		if ($validation->passes())
		{
			$this->overtime_policy->create($input);

			return Redirect::route('overtime_policies.index');
		}

		return Redirect::route('overtime_policies.index')
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
		$overtime_policy = $this->overtime_policy->findOrFail($id);

		return View::make('overtime_policies.show', compact('overtime_policy'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$overtime_policy = $this->overtime_policy->find($id);

		if (is_null($overtime_policy))
		{
			return Redirect::route('overtime_policies.index');
		}

		return View::make('overtime_policies.edit', compact('overtime_policy'));
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
		$validation = Validator::make($input, Overtime_policy::$rules);

		if ($validation->passes())
		{
			$overtime_policy = $this->overtime_policy->find($id);
			$overtime_policy->update($input);

			return Redirect::route('overtime_policies.index', $id);
		}

		return Redirect::route('overtime_policies.edit', $id)
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
		$this->overtime_policy->find($id)->delete();

		return Redirect::route('overtime_policies.index');
	}

}
