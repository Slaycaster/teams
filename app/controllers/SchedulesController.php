<?php

class SchedulesController extends BaseController {

	/**
	 * Schedule Repository
	 *
	 * @var Schedule
	 */
	protected $schedule;

	public function __construct(Schedule $schedule)
	{
		$this->schedule = $schedule;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$schedules = Schedule::paginate(6);

		return View::make('schedules.index', compact('schedules'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('schedules.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
			$id = DB::table('schedules')->max('id');
			$id = $id + 1;


			//MONDAY BREAK
			if( (!(Input::get('break_insMon1')=='')) && (!(Input::get('break_outsMon1')=='')))
			{
				$breakin = Input::get('break_insMon1');
				$breakout = Input::get('break_outsMon1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Monday'));
			}
			if( (!(Input::get('break_insMon2')=='')) && (!(Input::get('break_outsMon2')=='')))
			{
				$breakin = Input::get('break_insMon2');
				$breakout = Input::get('break_outsMon2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Monday'));
			}
			if( (!(Input::get('break_insMon3')=='')) && (!(Input::get('break_outsMon3')=='')))
			{
				$breakin = Input::get('break_insMon3');
				$breakout = Input::get('break_outsMon3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Monday'));
			}

			//TUESDAY BREAK
			if( (!(Input::get('break_insTue1')=='')) && (!(Input::get('break_outsTue1')=='')))
			{
				$breakin = Input::get('break_insTue1');
				$breakout = Input::get('break_outsTue1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Tuesday'));
			}
			if( (!(Input::get('break_insTue2')=='')) && (!(Input::get('break_outsTue2')=='')))
			{
				$breakin = Input::get('break_insTue2');
				$breakout = Input::get('break_outsTue2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Tuesday'));
			}
			if( (!(Input::get('break_insTue3')=='')) && (!(Input::get('break_outsTue3')=='')))
			{
				$breakin = Input::get('break_insTue3');
				$breakout = Input::get('break_outsTue3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Tuesday'));
			}
			
			//WEDNESDAY BREAK
			if( (!(Input::get('break_insWed1')=='')) && (!(Input::get('break_outsWed1')=='')))
			{
				$breakin = Input::get('break_insWed1');
				$breakout = Input::get('break_outsWed1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Wednesday'));
			}
			if( (!(Input::get('break_insWed2')=='')) && (!(Input::get('break_outsWed2')=='')))
			{
				$breakin = Input::get('break_insWed2');
				$breakout = Input::get('break_outsWed2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Wednesday'));
			}
			if( (!(Input::get('break_insWed3')=='')) && (!(Input::get('break_outsWed3')=='')))
			{
				$breakin = Input::get('break_insWed3');
				$breakout = Input::get('break_outsWed3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Wednesday'));
			}

			//THURSDAY BREAK
			if( (!(Input::get('break_insThu1')=='')) && (!(Input::get('break_outsThu1')=='')))
			{
				$breakin = Input::get('break_insThu1');
				$breakout = Input::get('break_outsThu1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Thursday'));
			}
			if( (!(Input::get('break_insThu2')=='')) && (!(Input::get('break_outsThu2')=='')))
			{
				$breakin = Input::get('break_insThu2');
				$breakout = Input::get('break_outsThu2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Thursday'));
			}
			if( (!(Input::get('break_insThu3')=='')) && (!(Input::get('break_outsThu3')=='')))
			{
				$breakin = Input::get('break_insThu3');
				$breakout = Input::get('break_outsThu3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Thursday'));
			}

			//FRIDAY BREAK
			if( (!(Input::get('break_insFri1')=='')) && (!(Input::get('break_outsFri1')=='')))
			{
				$breakin = Input::get('break_insFri1');
				$breakout = Input::get('break_outsFri1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Friday'));
			}
			if( (!(Input::get('break_insFri2')=='')) && (!(Input::get('break_outsFri2')=='')))
			{
				$breakin = Input::get('break_insFri2');
				$breakout = Input::get('break_outsFri2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Friday'));
			}
			if( (!(Input::get('break_insFri3')=='')) && (!(Input::get('break_outsFri3')=='')))
			{
				$breakin = Input::get('break_insFri3');
				$breakout = Input::get('break_outsFri3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Friday'));
			}

			//SATURDAY BREAK
			if( (!(Input::get('break_insSat1')=='')) && (!(Input::get('break_outsSat1')=='')))
			{
				$breakin = Input::get('break_insSat1');
				$breakout = Input::get('break_outsSat1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Saturday'));
			}
			if( (!(Input::get('break_insSat2')=='')) && (!(Input::get('break_outsSat2')=='')))
			{
				$breakin = Input::get('break_insSat2');
				$breakout = Input::get('break_outsSat2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Saturday'));
			}
			if( (!(Input::get('break_insSat3')=='')) && (!(Input::get('break_outsSat3')=='')))
			{
				$breakin = Input::get('break_insSat3');
				$breakout = Input::get('break_outsSat3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Saturday'));
			}

			//SUNDAY BREAK
			if( (!(Input::get('break_insSun1')=='')) && (!(Input::get('break_outsSun1')=='')))
			{
				$breakin = Input::get('break_insSun1');
				$breakout = Input::get('break_outsSun1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Sunday'));
			}
			if( (!(Input::get('break_insSun2')=='')) && (!(Input::get('break_outsSun2')=='')))
			{
				$breakin = Input::get('break_insSun2');
				$breakout = Input::get('break_outsSun2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Sunday'));
			}
			if( (!(Input::get('break_insSun3')=='')) && (!(Input::get('break_outsSun3')=='')))
			{
				$breakin = Input::get('break_insSun3');
				$breakout = Input::get('break_outsSun3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Sunday'));
			}

			
			$schedule = new Schedule;
			$schedule->schedule_name = Input::get('schedule_name');
			$schedule->description = Input::get('description');
			$schedule->m_timein = Input::get('m_timein');
			$schedule->m_timeout = Input::get('m_timeout');
			$schedule->t_timein = Input::get('t_timein');
			$schedule->t_timeout = Input::get('t_timeout');
			$schedule->w_timein = Input::get('w_timein');
			$schedule->w_timeout = Input::get('w_timeout');
			$schedule->th_timein = Input::get('th_timein');
			$schedule->th_timeout = Input::get('th_timeout');
			$schedule->f_timein = Input::get('f_timein');
			$schedule->f_timeout = Input::get('f_timeout');
			$schedule->sat_timein = Input::get('sat_timein');
			$schedule->sat_timeout = Input::get('sat_timeout');
			$schedule->sun_timein = Input::get('sun_timein');
			$schedule->sun_timeout = Input::get('sun_timeout');
			if (Input::has('break_punches'))
			{
				$schedule->require_break_punches = Input::get('break_punches');
			}
			$schedule->save();
			return Redirect::route('schedules.index');
		

		return Redirect::route('schedules.index')
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
		$schedule = $this->schedule->findOrFail($id);
		$employees = DB::table('empschedules')->where('schedule_id', '=', $schedule->id)->get();
		$mon_breaks = DB::table('breaks')->where('schedule_id', '=', $schedule->id)->where('day', '=', "MONDAY")->get();
		$tue_breaks = DB::table('breaks')->where('schedule_id', '=', $schedule->id)->where('day', '=', "TUESDAY")->get();
		$wed_breaks = DB::table('breaks')->where('schedule_id', '=', $schedule->id)->where('day', '=', "WEDNESDAY")->get();
		$thu_breaks = DB::table('breaks')->where('schedule_id', '=', $schedule->id)->where('day', '=', "THURSDAY")->get();
		$fri_breaks = DB::table('breaks')->where('schedule_id', '=', $schedule->id)->where('day', '=', "FRIDAY")->get();
		$sat_breaks = DB::table('breaks')->where('schedule_id', '=', $schedule->id)->where('day', '=', "SATURDAY")->get();
		$sun_breaks = DB::table('breaks')->where('schedule_id', '=', $schedule->id)->where('day', '=', "SUNDAY")->get();
		$employee_lists = array();
		$new_subordinates = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->orderBy('lname', 'asc')
			->lists('full_name', 'id');
		foreach ($employees as $employee) {
			$subordinates = DB::table('employs')->where('id', '=', $employee->employee_id)->get();			
			array_push($employee_lists, $subordinates);
		}
		sort($employee_lists);
		return View::make('schedules.show', compact('schedule'))
		->with('employee_lists', $employee_lists)
		->with('mon_breaks', $mon_breaks)
		->with('tue_breaks', $tue_breaks)
		->with('wed_breaks', $wed_breaks)
		->with('thu_breaks', $thu_breaks)
		->with('fri_breaks', $fri_breaks)
		->with('sat_breaks', $sat_breaks)
		->with('sun_breaks', $sun_breaks)
		->with('new_subordinates', $new_subordinates);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$schedule = $this->schedule->find($id);

		if (is_null($schedule))
		{
			return Redirect::route('schedules.index');
		}

		return View::make('schedules.edit', compact('schedule'));
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
		$validation = Validator::make($input, Schedule::$rules);

		if ($validation->passes())
		{
			DB::statement("DELETE FROM breaks WHERE schedule_id=:sid", array('sid'=>$id));
			//MONDAY BREAK
			if( (!(Input::get('break_insMon1')=='')) && (!(Input::get('break_outsMon1')=='')))
			{
				$breakin = Input::get('break_insMon1');
				$breakout = Input::get('break_outsMon1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Monday'));
			}
			if( (!(Input::get('break_insMon2')=='')) && (!(Input::get('break_outsMon2')=='')))
			{
				$breakin = Input::get('break_insMon2');
				$breakout = Input::get('break_outsMon2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Monday'));
			}
			if( (!(Input::get('break_insMon3')=='')) && (!(Input::get('break_outsMon3')=='')))
			{
				$breakin = Input::get('break_insMon3');
				$breakout = Input::get('break_outsMon3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Monday'));
			}

			//TUESDAY BREAK
			if( (!(Input::get('break_insTue1')=='')) && (!(Input::get('break_outsTue1')=='')))
			{
				$breakin = Input::get('break_insTue1');
				$breakout = Input::get('break_outsTue1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Tuesday'));
			}
			if( (!(Input::get('break_insTue2')=='')) && (!(Input::get('break_outsTue2')=='')))
			{
				$breakin = Input::get('break_insTue2');
				$breakout = Input::get('break_outsTue2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Tuesday'));
			}
			if( (!(Input::get('break_insTue3')=='')) && (!(Input::get('break_outsTue3')=='')))
			{
				$breakin = Input::get('break_insTue3');
				$breakout = Input::get('break_outsTue3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Tuesday'));
			}
			
			//WEDNESDAY BREAK
			if( (!(Input::get('break_insWed1')=='')) && (!(Input::get('break_outsWed1')=='')))
			{
				$breakin = Input::get('break_insWed1');
				$breakout = Input::get('break_outsWed1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Wednesday'));
			}
			if( (!(Input::get('break_insWed2')=='')) && (!(Input::get('break_outsWed2')=='')))
			{
				$breakin = Input::get('break_insWed2');
				$breakout = Input::get('break_outsWed2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Wednesday'));
			}
			if( (!(Input::get('break_insWed3')=='')) && (!(Input::get('break_outsWed3')=='')))
			{
				$breakin = Input::get('break_insWed3');
				$breakout = Input::get('break_outsWed3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Wednesday'));
			}

			//THURSDAY BREAK
			if( (!(Input::get('break_insThu1')=='')) && (!(Input::get('break_outsThu1')=='')))
			{
				$breakin = Input::get('break_insThu1');
				$breakout = Input::get('break_outsThu1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Thursday'));
			}
			if( (!(Input::get('break_insThu2')=='')) && (!(Input::get('break_outsThu2')=='')))
			{
				$breakin = Input::get('break_insThu2');
				$breakout = Input::get('break_outsThu2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Thursday'));
			}
			if( (!(Input::get('break_insThu3')=='')) && (!(Input::get('break_outsThu3')=='')))
			{
				$breakin = Input::get('break_insThu3');
				$breakout = Input::get('break_outsThu3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Thursday'));
			}

			//FRIDAY BREAK
			if( (!(Input::get('break_insFri1')=='')) && (!(Input::get('break_outsFri1')=='')))
			{
				$breakin = Input::get('break_insFri1');
				$breakout = Input::get('break_outsFri1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Friday'));
			}
			if( (!(Input::get('break_insFri2')=='')) && (!(Input::get('break_outsFri2')=='')))
			{
				$breakin = Input::get('break_insFri2');
				$breakout = Input::get('break_outsFri2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Friday'));
			}
			if( (!(Input::get('break_insFri3')=='')) && (!(Input::get('break_outsFri3')=='')))
			{
				$breakin = Input::get('break_insFri3');
				$breakout = Input::get('break_outsFri3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Friday'));
			}

			//SATURDAY BREAK
			if( (!(Input::get('break_insSat1')=='')) && (!(Input::get('break_outsSat1')=='')))
			{
				$breakin = Input::get('break_insSat1');
				$breakout = Input::get('break_outsSat1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Saturday'));
			}
			if( (!(Input::get('break_insSat2')=='')) && (!(Input::get('break_outsSat2')=='')))
			{
				$breakin = Input::get('break_insSat2');
				$breakout = Input::get('break_outsSat2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Saturday'));
			}
			if( (!(Input::get('break_insSat3')=='')) && (!(Input::get('break_outsSat3')=='')))
			{
				$breakin = Input::get('break_insSat3');
				$breakout = Input::get('break_outsSat3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Saturday'));
			}

			//SUNDAY BREAK
			if( (!(Input::get('break_insSun1')=='')) && (!(Input::get('break_outsSun1')=='')))
			{
				$breakin = Input::get('break_insSun1');
				$breakout = Input::get('break_outsSun1');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Sunday'));
			}
			if( (!(Input::get('break_insSun2')=='')) && (!(Input::get('break_outsSun2')=='')))
			{
				$breakin = Input::get('break_insSun2');
				$breakout = Input::get('break_outsSun2');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Sunday'));
			}
			if( (!(Input::get('break_insSun3')=='')) && (!(Input::get('break_outsSun3')=='')))
			{
				$breakin = Input::get('break_insSun3');
				$breakout = Input::get('break_outsSun3');
				DB::statement("INSERT INTO breaks (schedule_id, break_in, break_out, day) VALUES (:sid, :bin, :bout, :day)", array('sid' => $id, 'bin' => $breakin, 'bout' => $breakout, 'day' => 'Sunday'));
			}

			$schedule = $this->schedule->find($id);
			$schedule->schedule_name = Input::get('schedule_name');
			$schedule->description = Input::get('description');
			$schedule->m_timein = Input::get('m_timein');
			$schedule->m_timeout = Input::get('m_timeout');
			$schedule->t_timein = Input::get('t_timein');
			$schedule->t_timeout = Input::get('t_timeout');
			$schedule->w_timein = Input::get('w_timein');
			$schedule->w_timeout = Input::get('w_timeout');
			$schedule->th_timein = Input::get('th_timein');
			$schedule->th_timeout = Input::get('th_timeout');
			$schedule->f_timein = Input::get('f_timein');
			$schedule->f_timeout = Input::get('f_timeout');
			$schedule->sat_timein = Input::get('sat_timein');
			$schedule->sat_timeout = Input::get('sat_timeout');
			$schedule->sun_timein = Input::get('sun_timein');
			$schedule->sun_timeout = Input::get('sun_timeout');
			if (Input::has('break_punches'))
			{
				$schedule->require_break_punches = Input::get('break_punches');
			}
			$schedule->save();

			return Redirect::route('schedules.show', $id);
		}

		return Redirect::route('schedules.edit', $id)
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
		$this->schedule->find($id)->delete();

		return Redirect::route('schedules.index');
	}


	public function addExtraEmployees()
	{
		$empsched_id = DB::table('empschedules')->max('id');
		
		$schedule_id = Input::get('schedule_id');
		$new_employees = Input::get('new_subordinates');

			foreach ($new_employees as $new_employee) {	
				$empsched_id = $empsched_id + 1;
				DB::table('empschedules')->insert(array(
					array('id' => $empsched_id, 'schedule_id' => $schedule_id, 'employee_id' => $new_employee)
				));
			}
				
			return Redirect::route('schedules.index');
	}


	public function removeEmployees()
	{
		$schedule_id = Input::get('schedule_id');
		$employee_id = Input::get('employee_id');

			DB::table('empschedules')
				->where('employee_id', '=', $employee_id)
				->delete();
				
			return Redirect::route('schedules.index');
	}
}
