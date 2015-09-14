<?php

class PayPeriodsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pay_periods=Pay_period::all();

		return View::make('pay_periods.index')
			->with('pay_periods', $pay_periods);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('pay_periods.index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
            'name'       => 'required',
            'type'	=>	'required',
            'payperiod_day'	=> 'required',
            'initial_payperiod' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);


  		 // process the login
        if ($validator->fails()) {
            return Redirect::to('pay_periods/create')
                ->withErrors($validator);
        } else {
            // store
            $pay_period = new Pay_period;
            $pay_period->name       = Input::get('name');
            $pay_period->description      = Input::get('description');
            $pay_period->type = Input::get('type');
            $pay_period->payperiod_day = Input::get('payperiod_day');
            $pay_period->initial_payperiod = Input::get('initial_payperiod');
            $pay_period->save();

            // redirect
            Session::flash('message', 'Successfully created Pay Period!');
            return Redirect::to('pay_periods');
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// get the nerd
        $pay_period = Pay_period::find($id);

        // show the view and pass the nerd to it
        return View::make('pay_periods.show')
            ->with('pay_period', $pay_period);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the nerd
        $pay_period = Pay_period::find($id);

        // show the edit form and pass the nerd
        return View::make('pay_periods.edit')
            ->with('pay_period', $pay_period);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
            'name'       => 'required',
            'type'	=>	'required',
            'payperiod_day'	=> 'required',
            'initial_payperiod' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);


  		 // process the login
        if ($validator->fails()) {
            return Redirect::to('pay_periods/' . $id . '/edit')
                ->withErrors($validator);
        } else {
            // store
            $pay_period = Pay_period::find($id);
            $pay_period->name       = Input::get('name');
            $pay_period->description      = Input::get('description');
            $pay_period->type = Input::get('type');
            $pay_period->payperiod_day = Input::get('payperiod_day');
            $pay_period->initial_payperiod = Input::get('initial_payperiod');
            $pay_period->save();

            // redirect
            Session::flash('message', 'Successfully updated Pay Period!');
            return Redirect::to('pay_periods');
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
