<?php

class Holiday_policiesController extends BaseController {

	/**
	 * Holiday_policy Repository
	 *
	 * @var Holiday_policy
	 */
	protected $holiday_policy;

	public function __construct(Holiday_policy $holiday_policy)
	{
		$this->holiday_policy = $holiday_policy;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$holiday_policies = $this->holiday_policy->all();
		$branches = DB::table('branches')
		->lists('branch_name','id');
		return View::make('holiday_policies.index', compact('holiday_policies'))
		->with('branches',$branches);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('holiday_policies.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Holiday_policy::$rules);
		$holiday_id = DB::table('holiday_policies')->max('id');
		$holiday_id = $holiday_id + 1;
		if ($validation->passes())
		{
			$holiday = new Holiday_policy;
			$holiday->holiday_name = Input::get('holiday_name');
			$holiday->description = Input::get('description');
			$holiday->default_schedule_status = Input::get('default_schedule_status');
			$holiday->holiday_type = Input::get('holiday_type');
			$holiday->recurring = Input::get('recurring');
			$holiday->day_of_month = Input::get('day_of_month');
			$holiday->month = Input::get('month');
			$holiday->year = Input::get('year');

			$branches = Input::get('branches');

			foreach ($branches as $branch) {	
				DB::table('branches_holidays')->insert(array(
					array('holiday_id' => $holiday_id, 'branch_id' => $branch)
				));
			}
				
			$holiday->save();

			return Redirect::route('holiday_policies.index');
		}

		return Redirect::route('holiday_policies.index')
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
		$holiday_policy = $this->holiday_policy->findOrFail($id);

		return View::make('holiday_policies.show', compact('holiday_policy'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$holiday_policy = $this->holiday_policy->find($id);

		if (is_null($holiday_policy))
		{
			return Redirect::route('holiday_policies.index');
		}

		return View::make('holiday_policies.edit', compact('holiday_policy'));
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
		$validation = Validator::make($input, Holiday_policy::$rules);

		if ($validation->passes())
		{
			$holiday_policy = $this->holiday_policy->find($id);
			$holiday_policy->update($input);

			return Redirect::route('holiday_policies.index', $id);
		}

		return Redirect::route('holiday_policies.index', $id)
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
		$this->holiday_policy->find($id)->delete();

		return Redirect::route('holiday_policies.index');
	}

}
