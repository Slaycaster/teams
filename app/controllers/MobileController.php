<?php

class MobileController extends BaseController {

	public function showSchedule()
	{
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$request = json_decode($postdata);
			$id = $request->emp_id;
		}
		else {
			echo "Not called properly with username parameter!";
		}
		$schedule_id = DB::table('empschedules')
		->select('schedule_id')
		->where('employee_id','=',$id)
		->lists('schedule_id');
		$schedule = DB::table('schedules')
		->whereIn('id',$schedule_id)
		->get();

		return Response::json($schedule);
	}

	public function showLeaveCredits()
	{
			$postdata = file_get_contents("php://input");
			if (isset($postdata)) {
				$request = json_decode($postdata);
				$id = $request->emp_id;
			}
			else {
				echo "Not called properly with username parameter!";
			}

			$employees = DB::table('employs')->get();
			$credits = DB::table('leavecredits')->get();
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			
			// MySQL datetime format
			
			foreach ($employees as $employee) {
			
			if ($employee->id == $id)
			{
			
				$hdate = $employee->hire_date;
				$ts1=strtotime($hdate);
				$ts2=strtotime($now);

				$year1 = date('Y', $ts1);
				$year2 = date('Y', $ts2);

				$month1 = date('m', $ts1);
				$month2 = date('m', $ts2);

				$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
				$day2 = date('d', $ts2);

				$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

				/* IF THE DAY2 IS LESS THAN DAY1, IT WILL LESSEN THE $diff VALUE BY ONE */

			if($day2<$day1)
				{ $diff=$diff-1; }

		
				if($diff >= 12)
					{
						$diff = $diff - 12;
						if ($diff >= 12){
							$totyear= round($totyear = ($diff / 12), 0);
							$totmonth = round(($diff % 12), 0);
						foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

									$sick_leave = (($totyear *15) + $totmonth * 1.25) - $credit->sick_leave;

									$vacation_leave = (($totyear *15) + $totmonth * 1.25) - $credit->vacation_leave;
								

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
								$sick_leave = (($totyear *15) + $totmonth * 1.25);

								$vacation_leave = (($totyear *15) + $totmonth * 1.25) ;
								}
						
							if($vacation_leave >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

								$force_counter = 5 * $totyear;
								$force_leave = 5;
								$vacation_leave = (($totyear *15) + $totmonth * 1.25) - $force_counter - $credit->vacation_leave;

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_counter = 5 * $totyear;
									$force_leave = 5;
									$vacation_leave = (($totyear *15) + $totmonth * 1.25) - $force_counter;
								}

							}
							else {
								$force_leave = 0;
							}
						}
						if($diff < 12)
						{
							foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$sick_leave = ($diff * 1.25) - $credit->sick_leave;
								$vacation_leave = ($diff * 1.25) - $credit->vacation_leave; }}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$sick_leave = $diff * 1.25;
									$vacation_leave = $diff * 1.25;
								}
								if($vacation_leave >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$force_leave = 5;
								$vacation_leave = ($diff * 1.25) - $force_leave - $credit->vacation_leave;}}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_leave = 5;
									$vacation_leave = ($diff * 1.25) - $force_leave[$i];
								}
							}
							else {
								$force_leave = 0;
							}
						}

						
						}
					
					else {
						$sick_leave = 0;
						$vacation_leave = 0;
						$force_leave = 0;
						}
			}//if employee match
		}

		

		//Returns leaves in JSON Array
		$leaves = array(
			"sick_leave" => $sick_leave,
			"vacation_leave" => $vacation_leave,
			"force_leave" => $force_leave
		);

		return Response::json($leaves);
	}//function

	public function changePassword()
	{
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$request = json_decode($postdata);
			$old_password = $request->old_password;
			$new_password = $request->new_password;
			$confirm_new_password = $request->confirm_new_password;
			$id = $request->id;
		}
		else {
			echo "Not called properly with username parameter!";
		}
		$validator = Validator::make(
			array('old_password' => $old_password, 
				  'new_password' => $new_password,
				  'password_again' => $confirm_new_password),
			array(
				'new_password' 		=> 'required',
				'old_password'	=> 'required|min:6',
				'password_again'=> 'required|same:new_password'
			)
		);

		if($validator->fails()) 
		{
			$res = array(
				"message" => "222 Passwords didn't match. Please try again."
			);
			return Response::json($res);

		} else {

			$db_old_password = DB::table('employs')->select('password as old_password')->where('id', '=', $id)->get();		
			
			foreach ($db_old_password as $value) {
				if ($old_password == $value->old_password) 
				{
					DB::table('employs')->where('id', '=', $id)->update(array('password' => Input::get('new_password')));
					$res = array(
						"message" => "Password successfully changed!"
					);
					return Response::json($res);
				}
				else
				{
					$res = array(
						"message" => "Passwords didn't match. Please try again."
					);
					return Response::json($res);
				}
			}
			

		}
	}

	public function showAccumulatedHours()
	{
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$request = json_decode($postdata);
			$datefrom = $request->date_from;
			$dateto = $request->date_to;
			$id = $request->id;
		}
		else {
			echo "Not called properly with username parameter!";
		}
		$datefrom = date('Y-m-d', strtotime('+1 day', strtotime($datefrom)));
		$dateto = date('Y-m-d', strtotime('+1 day', strtotime($dateto)));
			$acchrs = 0;
			$total = 0;
			$overtime = 0;
			$hrs = 0;
			$othrs = 0;
			$year = date('Y');
			$date = date('d');
			$month = date('m');
			$totalminutes = 0;
			$overtimemin =0;
			$curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));
            $format_day = strtotime($curr_date);
            $day_name = date('l', $format_day);
			//$datefrom = Input::get('datefrom');
			//$dateto = Input::get('dateto');
			//$now = Input::get('datefrom');
			//$to = "to";
			//$id = Session::get('empid', 'default');
			//$name = Session::get('empname', 'default');
			//$email = Session::get('empemail', 'default');
			//$level = Session::get('emplevel', 'default');
			//$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$ifot = DB::table('overtime_subordinates')
			->select('overtime_id')
			->where('employee_id','=',$id)
			->lists('overtime_id');
			if($ifot != null)
			{
				$allowedothr = DB::table('overtime_policies')
				->where('id','=',$ifot)
				->get();
			}
			$ifsched = DB::table('empschedules')
			->select('schedule_id')
			->where('employee_id','=',$id)
			->lists('schedule_id');
			if($ifsched != null)
			{
				if($day_name == 'Monday')
				{	
					$schedto = DB::table('schedules')
					->select('m_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Monday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				
				}
				if($day_name == 'Tuesday')
				{	
					$schedto = DB::table('schedules')
					->select('t_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Tuesday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Wednesday')
				{	
					$schedto = DB::table('schedules')
					->select('w_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Wednesday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Thursday')
				{	
					$schedto = DB::table('schedules')
					->select('th_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Thursday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Friday')
				{	
					$schedto = DB::table('schedules')
					->select('f_timeout')
					->where('id','=',$ifsched)
					->lists('f_timeout');
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Friday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
					
					
				}
				if($day_name == 'Saturday')
				{	
					$schedto = DB::table('schedules')
					->select('sat_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Saturday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Sunday')
				{	
					$schedto = DB::table('schedules')
					->select('sun_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Sunday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
			
			}
			$punchin = DB::table('punchstatus')
			->select('time_in_punch_id')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('employee_id','=',$id)
			->lists('time_in_punch_id');
			$punchout =DB::table('punchstatus')
			->select('time_out_punch_id')
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->where('employee_id','=',$id)
			->lists('time_out_punch_id');
			$breakin =DB::table('punchstatus')
			->select('break_in_punch_id')
			->where('employee_id','=',$id)
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->lists('break_in_punch_id');

			$breakout =DB::table('punchstatus')
			->select('break_out_punch_id')
			->where('employee_id','=',$id)
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->lists('break_out_punch_id');
			if($punchin != null && $punchout != null)
			{
				$timein = DB::table('punches')
				->whereIn('id',$punchin)
				->get();
				
				$timeout = DB::table('punches')
				->whereIn('id',$punchout)
				->get();

				$inbreak = DB::table('punches')
				->select('time')
				->where('id','=',$breakin)
				->get();

				$outbreak = DB::table('punches')
				->select('time')
				->where('id','=',$breakout)
				->get();
				
				foreach($timeout as $time_out)
				{
					foreach($timein as $time_in)
					{
						foreach($schedto as $sched)
						{

							$timeout = $time_out->time +12;
							if($timeout > $sched)
							{
								$breakminutes = 0;
								foreach($break as $breaks)
						   		{
						   			if($ifreqbreak == 'No')
						   			{
						   				
									//split break in in hours and minutes
										$separatedData = explode(':', $breaks->break_in);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakinMinutes = $minutesInHours + $minutesInDecimals;

										$separatedData = explode(':', $breaks->break_out);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakoutMinutes = $minutesInHours + $minutesInDecimals;
										$breakminutes = $breakoutMinutes - $breakinMinutes;
						   			}
						   			else
						   			{

						   				if($inbreak != null && $outbreak != null)
						   				{ 
						   					foreach($inbreak as $inbreaks)
						   					{
						   						$separatedData = explode(':', $inbreaks->time);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;
											}
											
											foreach($outbreak as $outbreaks)
						   					{
												$separatedData = explode(':', $outbreaks->time);
												$minutesInHours    = ($separatedData[0] +12) * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
											}
											
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
										else
										{
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
						   			}
						   	
								}

								if($ifot != null)
								{
									foreach($allowedothr as $hr)
									{
										foreach($schedto as $schedout)
										{
											$allowed = $hr->Allowed_number_of_hours*60;
											$activeafter = $hr->active_after*60;
											$separatedData = explode(':', $schedout);
											$minutesInHours    = ($separatedData[0]) * 60;
											$minutesInDecimals = $separatedData[1];
											$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											$span = ($totalMinutes1 + $allowed) + $activeafter;
											//$span = ($schedout + $hr->Allowed_number_of_hours) + $hr->active_after;
											$hours = floor($span / 60);
											$decimalMinutes = $span - floor($span/60) * 60;
											$spanhr = sprintf("%d:%02.0f", $hours, $decimalMinutes);
										//$span = ($schedout->m_timeout + $hr->Allowed_number_of_hours) + $hr->active_after;
											
											//if($time_out->time > $span)
											//{
											//	$overtime = ($span - $schedout->m_timeout) - $hr->active_after;
											//}
											if($timeout > $spanhr)
											{
												$overtimemin = ($span - $totalMinutes1) - $activeafter;
												$hours = floor($overtimemin / 60);
												$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
				
												$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												
												//$overtime = ($span - $schedout) - $hr->active_after;
											}
											else
											{	// Split time out in hours and minutes.
												$separatedData = explode(':', $time_out->time);
												$minutesInHours    = ($separatedData[0] +12	) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes2 = $minutesInHours + $minutesInDecimals;
												
												$separatedData = explode(':', $schedout);
												$minutesInHours    = ($separatedData[0]) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											
												$activeafter = $hr->active_after*60;
												$overtimemin = ($totalMinutes2 - $totalMinutes1) - $activeafter;

												$hours = floor($overtimemin / 60);
												$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
												
												$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												

												//$overtime = ($time_out->time - $schedout->m_timeout) - $hr->active_after;
											}
											$separatedData = explode(':', $sched);


											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];

											$totalMinutes = $minutesInHours + $minutesInDecimals;
									
											// Split time out in hours and minutes.
											$separatedData = explode(':', $time_in->time);

											$minutesInHours    = ($separatedData[0] +12	) * 60;
											$minutesInDecimals = $separatedData[1];
		
											$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
											//convert minutes to hours:minutes
											$mulated = $totalMinutes - $totalMinutes2;
											
											$mulated = $mulated + 720;
											$mulated = $mulated - $breakminutes;
											$hours = floor($mulated / 60);
											$decimalMinutes = $mulated - floor($mulated/60) * 60;
											
											$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

											$acchrs = $hoursMinutes;
											$total = $mulated + $overtime;
											$hours = floor($total / 60);
											$decimalMinutes = $total - floor($total/60) * 60;
											
											$totalMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
											//$total = $totalMinutes;

											//$acchrs = $schedout->m_timeout - $time_in->time;
								
											//if($acchrs < 0 )
											//{
											//	$acchrs = $acchrs + 12;
											//}
										}
									}
								}
								else
								{
									$separatedData = explode(':', $sched);


									$minutesInHours    = $separatedData[0] * 60;
									$minutesInDecimals = $separatedData[1];

									$totalMinutes = $minutesInHours + $minutesInDecimals;
									
									// Split time out in hours and minutes.
									$separatedData = explode(':', $time_in->time);

									$minutesInHours    = ($separatedData[0] +12	) * 60;
									$minutesInDecimals = $separatedData[1];

									$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
									//convert minutes to hours:minutes
									$mulated = $totalMinutes - $totalMinutes2;
									
									$mulated = $mulated + 720;
									$mulated = $mulated - $breakminutes;
									$hours = floor($mulated / 60);
									$decimalMinutes = $mulated - floor($mulated/60) * 60;
									
									$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

									$acchrs = $hoursMinutes;
									$total = $hoursMinutes;
									//foreach($schedto as $schedout)
									//{
									//	$acchrs = $schedout->m_timeout - $time_in->time;
									//	if($acchrs < 0 )
									//	{
									//		$acchrs = $acchrs + 12;
							
										//}
								
									//}
								}
							}
							else
							{
								$breakminutes = 0;
								foreach($break as $breaks)
						   		{
						   			if($ifreqbreak == 'No')
						   			{
						   				
									//split break in in hours and minutes
										$separatedData = explode(':', $breaks->break_in);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakinMinutes = $minutesInHours + $minutesInDecimals;

										$separatedData = explode(':', $breaks->break_out);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakoutMinutes = $minutesInHours + $minutesInDecimals;
										$breakminutes = $breakoutMinutes - $breakinMinutes;
						   			}
						   			else
						   			{

						   				if($inbreak != null && $outbreak != null)
						   				{ 
						   					foreach($inbreak as $inbreaks)
						   					{
						   						$separatedData = explode(':', $inbreaks->time);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;
											}
											
											foreach($outbreak as $outbreaks)
						   					{
												$separatedData = explode(':', $outbreaks->time);
												$minutesInHours    = ($separatedData[0] +12) * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
											}
											
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
										else
										{
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
						   			}
						   	
								}
								$separatedData = explode(':', $time_in->time);
								$minutesInHours    = $separatedData[0] * 60;
								$minutesInDecimals = $separatedData[1];
								$totalMinutes = $minutesInHours + $minutesInDecimals;

							// Split time out in hours and minutes.
								$separatedData = explode(':', $time_out->time);
								$minutesInHours    = $separatedData[0] * 60;
								$minutesInDecimals = $separatedData[1];
								$totalMinutes2 = $minutesInHours + $minutesInDecimals;
							
							//convert minutes to hours:minutes
								$mulated = $totalMinutes2 - $totalMinutes;
								$mulated = ($mulated + 720)-$breakminutes;
								$overtimemin = 0;
								//$hours = floor($mulated / 60);
								//$decimalMinutes = $mulated - floor($mulated/60) * 60;
								
								//$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
								//$acchrs = $hoursMinutes ;
								//$total = $hoursMinutes;
								
								//$acchrs = $time_out->time - $time_in->time;
								//if($acchrs < 0 )
								//{
								//	$acchrs = $acchrs + 12;	
								//}							
							}
						}
					}

					$othrs = $othrs + $overtimemin;
					$hrs = $hrs + $mulated;
					$totalminutes = $totalminutes + $mulated + $overtimemin;

					$hours = floor($totalminutes / 60);
					$decimalMinutes = $totalminutes - floor($totalminutes/60) * 60;
					$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
					$total = $hoursMinutes;	

									
				}

				$hours = floor($hrs / 60);
				$decimalMinutes = $hrs - floor($hrs/60) * 60;
				$acchrsMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
				$acchrs = $acchrsMinutes;
				
				$hours = floor($othrs / 60);
				$decimalMinutes = $othrs - floor($othrs/60) * 60;
				$otMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
				$overtime = $otMinutes;
				
			}
			//Returns in JSON Array
			$accumulated = array(
				"acchrs" => $acchrs,
				"overtime" => $overtime,
				"total" => $total,
				"date_from" => $datefrom,
				"date_to" => $dateto
			);

			return Response::json($accumulated);
			/*
			return View::make('accumulated_hours')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('total',$total)
				->with('overtime',$overtime)
				->with('supervisor',$supervisor)
				->with('punchin',$punchin)
				->with('punchout',$punchout)
				->with('now',$now)
				->with('dateto',$dateto)
				->with('acchrs',$acchrs)
				->with('level', $level)
				->with('to',$to);
			*/	
		
	}

	public function showPunctualityAssessment()
	{
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$request = json_decode($postdata);
			$datefrom = $request->date_from;
			$dateto = $request->date_to;
			$id = $request->id;
		}
		else {
			echo "Not called properly with username parameter!";
		}

			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$datefrom = date('Y-m-d', strtotime('+1 day', strtotime($datefrom)));
			$dateto = date('Y-m-d', strtotime('+1 day', strtotime($dateto)));
			$ontime=DB::table('punchstatus')
			->select('time_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_in','=','On-Time')
			->where('employee_id','=',$id)
			->count();
			$late=DB::table('punchstatus')
			->select('time_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_in','=','Late')
			->where('employee_id','=',$id)
			->count();
			$earlyout = DB::table('punchstatus')
			->select('time_out')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_out','=','Early out')
			->where('employee_id','=',$id)
			->count();
			$absent=DB::table('punchstatus')
			->select('time_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_in','=','Absent')
			->where('employee_id','=',$id)
			->count();
			$earlybreak = DB::table('punchstatus')
			->select('break_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('break_in','=','Early break')
			->where('employee_id','=',$id)
			->count();
			$longbreak = DB::table('punchstatus')
			->select('break_out')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('break_out','=','Long break')
			->where('employee_id','=',$id)
			->count();

			//Returns in JSON Array
			$assessments = array(
				"ontime" => $ontime,
				"late" => $late,
				"earlyout" => $earlyout,
				"absent" => $absent,
				"earlybreak" => $earlybreak,
				"longbreak" => $longbreak
			);

			return Response::json($assessments);
	}//showPunctualityAssessment

	public function fileALeave()
	{
		
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$request = json_decode($postdata);
			$emp_id = $request->emp_id;
			$type = $request->request_type;
			$now = $request->end_date;
			$hdate = $request->start_date;
			$start_date = $request->start_date;
			$end_date = $request->end_date;
			$message = $request->message;
		}
		else {
			echo "Not called properly with username parameter!";
		}
		$hdate = date('Y-m-d', strtotime('+1 day', strtotime($hdate)));
		$now = date('Y-m-d', strtotime('+1 day', strtotime($now)));
		$start_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
		$end_date = date('Y-m-d', strtotime('+1 day', strtotime($end_date)));
		/*TEST DATA
		$emp_id = 10;
		$type = 'Vacation Leave';
		$now = '10-07-2015';
		$hdate = '10-02-2015';
		$message = 'Going on a vacay!';
		*/
		$s_leave = 0;
		$v_leave = 0;
		$f_leave = 0;

	
			//$now = Input::get('end_date');
			//$hdate = Input::get('start_date');
			$request_date = date("Y-m-d"); 
			$ts1=strtotime($hdate);
			$ts2=strtotime($now);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
			$day2 = date('d', $ts2);

			$deduct = (($year2 - $year1) * 360) + (($month2 - $month1)*12) + ($day2 - $day1) + 1;


			$leavecredits = DB::table('leavecredits')->get();
			//$emp_id = Session::get('empid', 'default');
			foreach ($leavecredits as $leavecredit)
		{
	
		if ($leavecredit->employee_id == $emp_id)
			{
			$employee_id = $emp_id;
			//$type = Input::get('request_type');
			if ($type == 'Sick Leave')
				{
				$s_leave = $deduct + $leavecredit->sick_leave;
				$v_leave = $leavecredit->vacation_leave;
				$f_leave = $leavecredit->force_leave;
				}
			if ($type == 'Vacation Leave') {
				$s_leave = $leavecredit->sick_leave;
				$v_leave = $deduct + $leavecredit->vacation_leave;
				$f_leave = $leavecredit->force_leave;
				}

			if ($type == 'Force Leave') {
				$s_leave = $leavecredit->sick_leave;
				$v_leave = $leavecredit->vacation_leave;
				$f_leave = $deduct + $leavecredit->force_leave;
				}
			}
		} 

			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$i = 0;
			$credits = DB::table('leavecredits')->get();
			   // MySQL datetime format
			$employs = DB::table('employs')->where('employs.id', '=', $emp_id)->get();
			foreach ($employs as $employee) {
			
			$hdate = $employee->hire_date;
			$ts1=strtotime($hdate);
			$ts2=strtotime($now);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
			$day2 = date('d', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

			/* IF THE DAY2 IS LESS THAN DAY1, IT WILL LESSEN THE $diff VALUE BY ONE */

			if($day2<$day1){ $diff=$diff-1; }

		
				
				if($diff >= 12)
					{
						$diff = $diff - 12;
						if ($diff >= 12){
							$totyear= round($totyear = ($diff / 12), 0);
							$totmonth = round(($diff % 12), 0);
							foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

									$sick_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $s_leave;

									$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $v_leave;
								

							}
						}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
								$sick_leaves[$i] = (($totyear *15) + $totmonth * 1.25);

								$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) ;
								}
							
							if($vacation_leaves[$i] >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

								$force_counter = 5 * $totyear;
								$force_leaves[$i] = 5 - $f_leave;
								$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter - $v_leave;

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_counter = 5 * $totyear;
									$force_leaves[$i] = 5;
									$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter;
								}

							}
							else {
								$force_leaves[$i] = 0;
							}
						
					}
						if($diff < 12)
						{
							foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$sick_leaves[$i] = ($diff * 1.25) - $s_leave;
								$vacation_leaves[$i] = ($diff * 1.25) - $v_leave; }}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$sick_leaves[$i] = $diff * 1.25;
									$vacation_leaves[$i] = $diff * 1.25;
								}
								if($vacation_leaves[$i] >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$force_leaves[$i] = 5 - $f_leave;
								$vacation_leaves[$i] = ($diff * 1.25) - $force_leaves[$i] - $v_leave;}}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_leave[$i] = 5;
									$vacation_leaves[$i] = ($diff * 1.25) - $force_leave[$i];
								}
							}
							else {
								$force_leaves[$i] = 0;
							}
						}

						
						}
					
					else {
						$sick_leaves[$i] = 0;
						$vacation_leaves[$i] = 0;
						$force_leaves[$i] = 0;
						}
						
						$check = DB::table('create_requests')->where('employee_id', '=', $emp_id)->where('status', '=', 'pending')->get();
						if($check == null)
						{
							if ($sick_leaves[$i] >= 0 && $vacation_leaves[$i] >= 0 && $force_leaves[$i] >= 0)
							{
								DB::table('create_requests')->insert(array(
									array('status' => 'pending',
										  'request_date' => $request_date,
										  'end_date' => $end_date,
										  'start_date' => $start_date,
										  'message' => $message,
										  'request_type' => $type,
										  'employee_id' => $emp_id
									)
								));
								$res = array(
									"message" => "Leave successfully filed, now pending approval from your supervisor"
								);
								return Response::json($res);
							}
							else {
							$res = array(
									"message" => "Insufficient Leave Credits"
								);
							return Response::json($res);
							}
						}
						else {
							$res = array(
									"message" => "There is still a pending request"
								);
							return Response::json($res);
						}
						}
							$i = $i + 1;
					}
}