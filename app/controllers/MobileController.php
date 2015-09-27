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
}