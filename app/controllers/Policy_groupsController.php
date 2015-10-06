<?php

class Policy_groupsController extends BaseController {

	/**
	 * Premium_policy Repository
	 *
	 * @var Premium_policy
	 */
	protected $policy_group;

	public function __construct(Policy_group $policy_group)
	{
		$this->policy_group = $policy_group;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$policy_groups = policy_group:: paginate(9);
		$employees = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		 ->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('policygroup_employees')
                      ->whereRaw('policygroup_employees.employee_id = employs.id');
            })
		->orderBy('lname', 'asc')->lists('full_name', 'id');
		$exception_groups= DB::table('exception_groups')->get();
		$exception_groups_id=DB::table('exception_groups')
		->lists('exceptiongroup_name','id');
		$holiday_policies=DB::table('holiday_policies')->get();
		$holiday_policies_id=DB::table('holiday_policies')
		->lists('holiday_name','id');
		$overtime_policies=DB::table('overtime_policies')->get();
		$overtime_policies_id=DB::table('overtime_policies')
		->lists('overtime_name','id');
		$leave_grants=DB::table('leave_grants')->get();
		$leave_grants_id=DB::table('leave_grants')
		->lists('name','id');
		$credit_policies=DB::table('credit_policies')->get();
		$credit_policies_id=DB::table('credit_policies')
		->lists('name','id');

		return View::make('policy_groups.index', compact('policy_groups'))
		->with('exception_groups',$exception_groups)
		->with('exception_groups_id',$exception_groups_id)
		->with('holiday_policies',$holiday_policies)
		->with('holiday_policies_id',$holiday_policies_id)
		->with('overtime_policies',$overtime_policies)
		->with('overtime_policies_id',$overtime_policies_id)
		->with('leave_grants',$leave_grants)
		->with('leave_grants_id',$leave_grants_id)
		->with('credit_policies',$credit_policies)
		->with('credit_policies_id',$credit_policies_id)
		->with('employees', $employees);


		
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$accrual_policies=DB::table('accrual_policies')
		->lists('accrual_name','id');
		$exception_groups=DB::table('exception_groups')
		->lists('exceptiongroup_name','id');
		$holiday_policies=DB::table('holiday_policies')
		->lists('holiday_name','id');
		$overtime_policies=DB::table('overtime_policies')
		->lists('overtime_name','id');
		$premium_policies=DB::table('premium_policies')
		->lists('premium_name','id');
		$leave_grants=DB::table('leave_grants')
		->lists('name', 'id');
		$employees = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('policy_groups.create')
		->with('accrual_policies',$accrual_policies)
		->with('exception_groups',$exception_groups)
		->with('holiday_policies',$holiday_policies)
		->with('overtime_policies',$overtime_policies)
		->with('premium_policies',$premium_policies)
		->with('leave_grants',$leave_grants)
		->with('employees', $employees);

	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Policy_group::$rules);

		$policy_groupid = DB::table('policy_groups')->max('id');
		$policy_groupid = $policy_groupid + 1;

		if ($validation->passes())
		{
			//$this->policy_group->create($input);
			$policy_group = new Policy_group;
			$policy_group->policygroup_name = Input::get('policygroup_name');
			$policy_group->description = Input::get('description');
			$policy_group->exception_id = Input::get('exceptiongroup_id');

			$employees = Input::get('employees');

			foreach ($employees as $employee) {	
				DB::table('policygroup_employees')->insert(array(
					array('policygroup_id' => $policy_groupid, 'employee_id' => $employee)
				));
			}
			if (Input::has('overtime_id')) {
				$overtimes = Input::get('overtime_id');

				foreach ($overtimes as $overtime) {
					DB::table('policy_group_overtime')->insert(array(
						array('policy_group_id' => $policy_groupid, 'overtime_id' => $overtime)
					));
				}
			}
				
			if (Input::has('premium_id')) {
				$premiums = Input::get('premium_id');

				foreach ($premiums as $premium) {
					DB::table('policy_group_premium')->insert(array(
						array('policy_group_id' => $policy_groupid, 'premium_id' => $premium)
					));
				}
			}
			
			if (Input::has('holiday_id')) {
				$holidays = Input::get('holiday_id');

				foreach ($holidays as $holiday) {
					DB::table('policy_group_holiday')->insert(array(
						array('policy_group_id' => $policy_groupid, 'holiday_id' => $holiday)
					));
				}
			}
			
		
			
			if (Input::has('accrual_id')) {
				$accruals = Input::get('accrual_id');

				foreach ($accruals as $accrual) {
					DB::table('policy_group_accrual')->insert(array(
						array('policy_group_id' => $policy_groupid, 'accrual_id' => $accrual)
					));
				}
			}
			
			if (Input::has('leavegrant_id')) {
				$leavegrants = Input::get('leavegrant_id');

				foreach ($leavegrants as $leavegrant) {
					DB::table('policy_group_leavegrants')->insert(array(
						array('policy_group_id' => $policy_groupid, 'leavegrant_id' => $leavegrant)
					));
				}
			}

			if (Input::has('credit_id')) {
				$creditpolicies = Input::get('credit_id');

				foreach ($creditpolicies as $creditpolicy) {
					DB::table('policy_group_credit')->insert(array(
						array('policy_group_id' => $policy_groupid, 'credit_id' => $creditpolicy)
					));
				}
			}

			$policy_group->save();
			return Redirect::route('policy_groups.index');
		}

		return Redirect::route('policy_groups.create')
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

		$policy_group = $this->policy_group->findOrFail($id);
		$employees = DB::table('policygroup_employees')->where('policygroup_id', '=', $policy_group->id)->get();
		$employee_lists = array();
		$new_subordinates = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('policygroup_employees')
                      ->whereRaw('policygroup_employees.employee_id = employs.id');
            })
			->orderBy('lname', 'asc')
			->lists('full_name', 'id');
		foreach ($employees as $employee) {
			$subordinates = DB::table('employs')->where('id', '=', $employee->employee_id)->get();			
			array_push($employee_lists, $subordinates);
		}
		sort($employee_lists);
		$accrual_pivot = DB::table('policy_group_accrual')->where('policy_group_id', '=', $id)->get();
		
		$holiday_pivot = DB::table('policy_group_holiday')->where('policy_group_id', '=', $id)->get();
		$overtime_pivot = DB::table('policy_group_overtime')->where('policy_group_id', '=', $id)->get();
		$premium_pivot = DB::table('policy_group_premium')->where('policy_group_id', '=', $id)->get();
		$leavegrant_pivot = DB::table('policy_group_leavegrants')->where('policy_group_id', '=', $id)->get();
		$credit_pivot = DB::table('policy_group_credit')->where('policy_group_id', '=', $id)->get();

		$accrual_policies = DB::table('accrual_policies')->get();
		
		$exception_groups= DB::table('exception_groups')->get();
		$holiday_policies=DB::table('holiday_policies')->get();
		$overtime_policies=DB::table('overtime_policies')->get();
		$leavegrant_policies=DB::table('leave_grants')->get();
		$premium_policies=DB::table('premium_policies')->get();
		$credit_policies=DB::table('credit_policies')->get();

		return View::make('policy_groups.show', compact('policy_group'))
		->with('accrual_policies',$accrual_policies)
	
		->with('exception_groups',$exception_groups)
		->with('holiday_policies',$holiday_policies)
		->with('overtime_policies',$overtime_policies)
		->with('employee_lists', $employee_lists)
		->with('new_subordinates', $new_subordinates)
		->with('premium_policies',$premium_policies)
		->with('leavegrant_policies',$leavegrant_policies)
		->with('credit_policies', $credit_policies)
		->with('accrual_pivot', $accrual_pivot)
		
		->with('holiday_pivot', $holiday_pivot)
		->with('overtime_pivot', $overtime_pivot)
		->with('premium_pivot', $premium_pivot)
		->with('credit_pivot', $credit_pivot)
		->with('leavegrant_pivot', $leavegrant_pivot);
	}

	public function addExtraSubordinates()
	{
		$policygroup_id = Input::get('policygroup_id');
		$new_subordinates = Input::get('new_subordinates');

			foreach ($new_subordinates as $new_subordinate) {	
				DB::table('policygroup_employees')->insert(array(
					array('policygroup_id' => $policygroup_id, 'employee_id' => $new_subordinate)
				));
			}
				
			return Redirect::route('policy_groups.index');
	}
	public function removeSubordinate()
	{
		$policygroup_id = Input::get('policygroup_id');
		$employee_id = Input::get('employee_id');

			DB::table('policygroup_employees')
				->where('policygroup_id', '=', $policygroup_id)
				->where('employee_id', '=', $employee_id)
				->delete();
				
			return Redirect::route('policy_groups.index');
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$policy_group = $this->policy_group->find($id);
	
		$exception_groups=DB::table('exception_groups')
		->lists('exceptiongroup_name','id');

		$holiday=DB::table('holiday_policies')
		->join('policy_group_holiday', 'holiday_policies.id', '=', 'policy_group_holiday.holiday_id')
		->join('policy_groups', 'policy_group_holiday.policy_group_id', '=', 'policy_groups.id')
		->where('policy_groups.id', '=', $id)->get();

		$holiday_policies=DB::table('holiday_policies')
		->lists('holiday_name','id');

		if (is_null($policy_group))
		{
			return Redirect::route('policy_groups.index');
		}

		return View::make('policy_groups.edit', compact('policy_group'))
		->with('holiday',$holiday)
		->with('exception_groups',$exception_groups)
		->with('holiday_policies',$holiday_policies);
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
		$validation = Validator::make($input, Policy_group::$rules);

		if ($validation->passes())
		{
			
		
			$policy_group = $this->policy_group->find($id);
			$policy_groupid = Input::get('policy_groupid');
			$policy_group->policygroup_name = Input::get('policygroup_name');
			$policy_group->description = Input::get('description');
			$policy_group->exception_id = Input::get('exceptiongroup_id');

			if (Input::has('holiday_id')) {
				$holidays = Input::get('holiday_id');

				foreach ($holidays as $holiday) {
					DB::table('policy_group_holiday')->insert(array(
						array('policy_group_id' => $policy_groupid, 'holiday_id' => $holiday)

					));
				}

			}

			if (Input::has('holiday_id_delete')) {
				$holidays = Input::get('holiday_id_delete');

				foreach ($holidays as $holiday) {
					DB::statement("DELETE FROM policy_group_holiday WHERE policy_group_id=:sid AND holiday_id=:sholiday",
					 array('sid'=>$policy_groupid, 'sholiday'=>$holiday));

				
				}

			}


			$policy_group->update();
			return Redirect::route('policy_groups.show', $id);
		}

		return Redirect::route('policy_groups.edit', $id)
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
		$this->policy_group->find($id)->delete();

		return Redirect::route('policy_groups.index');
	}

}
