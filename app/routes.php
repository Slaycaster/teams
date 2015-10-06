<?php
	Route::get('/', array('uses' => 'HomeController@showWelcome'));
	Route::get('login', array('uses' => 'HomeController@showLogin'));
	Route::get('login/employee', array('uses' => 'EmployeeLoginController@showLogin'));
	Route::post('login/employee', array('uses' => 'EmployeeLoginController@doLogin'));
	Route::get('employee/dashboard', array('uses' => 'EmployeeLoginController@showDashboard'));
	Route::get('employee/logout', array('uses' => 'EmployeeLoginController@doLogout'));
	Route::get('login/infotech', array('uses' => 'InfotechLoginController@showLogin'));
	Route::post('login/infotech', array('uses' => 'InfotechLoginController@doLogin'));
	Route::get('itechs/dashboard', array('uses' => 'InfotechLoginController@showDashboard'));
	Route::get('itechs/index', array('uses' => 'InfotechLoginController@showIndex'));
	Route::get('infotechs/logout', array('uses' => 'InfotechLoginController@doLogout'));
	Route::post('login', array('uses' => 'HomeController@doLogin'));
	Route::get('reportsdaily', array('uses' => 'HomeController@showPdfreports'));
	Route::get('logout', array('uses' => 'HomeController@doLogout'));
	Route::post('logout', array('uses' => 'HomeController@doLogout'));
	Route::get('employee/exceptions', array('uses' => 'EmployeeLoginController@showExceptions'));
	Route::get('employee/accruals', array('uses' => 'EmployeeLoginController@showAccruals'));
	Route::get('employee/requests_authorization', array('uses' => 'EmployeeLoginController@showRequestsAuthorization'));
	Route::post('employee/requests_authorized', array('uses' => 'EmployeeLoginController@postRequestsAuthorization'));
	Route::get('employee/attendance', array('uses' => 'AttendanceLoginController@showLogin'));
	Route::post('employee/attendance', array('uses' => 'AttendanceLoginController@doLogin'));
	Route::resource('create_requests', 'Create_requestsController');
	Route::resource('itechs', 'ItechsController');
	Route::resource('levels', 'LevelsController');
	Route::resource('employee/accumulated_hours','EmployeeLoginController@showAccumulatedHours');
	Route::post('change_password', array('uses' => 'EmployeeLoginController@changePassword'));
	Route::get('employee/change_password', array('uses' => 'EmployeeLoginController@showChangePassword'));
	Route::get('employee/dailytimerecord', array('uses' => 'EmployeeLoginController@showDTR'));
	Route::get('employee/downloads', array('uses' => 'EmployeeLoginController@showDownload'));
	Route::get('employee/empdownloads', array('uses' => 'EmployeeLoginController@showEmpdownload'));
	Route::post('employee/empdownloadshow', array('uses' => 'EmployeeLoginController@postEmpdownload'));
	Route::post('employee/downloads', array('uses' => 'EmployeeLoginController@showDownload'));
	Route::post('employee/pdfviewer', array('uses' => 'EmployeeLoginController@postPdf'));
	Route::post('employee/accmldthrs', array('uses' => 'EmployeeLoginController@postshowAccumulatedHours'));
	Route::post('employee/accmldthrssub', array('uses' => 'EmployeeLoginController@postshowAccumulatedSub'));
	Route::get('employee/leave_credits', array('uses' => 'EmployeeLoginController@showLeaveCredit'));
	Route::post('employee/postpunctassessment', array('uses' => 'EmployeeLoginController@postshowPunctualityAssessment'));
	Route::post('employee/punctassessmentsubpost', array('uses' => 'EmployeeLoginController@postshowPunctualitySub'));
	Route::get('employee/accmltddhrssubodinates', array('uses' => 'EmployeeLoginController@showAccumulatedSub'));
	Route::get('employee/punctassessmentsub', array('uses' => 'EmployeeLoginController@showPunctualitySub'));
	Route::get('employee/employeesummary', array('uses' => 'EmployeeLoginController@showEmployeeSummary'));
	Route::get('employee/dtrsubordinates', array('uses' => 'EmployeeLoginController@showDtrSubordinates'));
	Route::get('employee/schedulequery', array('uses' => 'EmployeeLoginController@showScheduleQuery'));
	Route::get('employee/leavehistory', array('uses' => 'EmployeeLoginController@showLeaveHistory'));
	Route::post('employee/leavehistory', array('uses' => 'EmployeeLoginController@postLeaveHistory'));
	Route::get('employee/requesthistory', array('uses' => 'EmployeeLoginController@showRequestHistory'));
	Route::get('employee/punctassessment', array('uses' => 'EmployeeLoginController@showPunctualityAssessment'));
	Route::get('employee/reports/assessment_sub', array('uses' => 'EmployeeLoginController@showPunctualityPDFSub'));
	Route::get('employee/reports/assessment', array('uses' => 'EmployeeLoginController@showPunctualityPdfAssessment'));
	Route::get('employee/reports/accumulated_sub', array('uses' => 'EmployeeLoginController@showAccumulatedPDFSub'));
	Route::get('employee/reports/accumulated', array('uses' => 'EmployeeLoginController@showAccumulatedPDF'));
	
	
	/*MOBILE APP ROUTES*/
	Route::post('api/schedule', array('uses' => 'MobileController@showSchedule'));
	Route::post('api/leavecredits', array('uses' => 'MobileController@showLeaveCredits'));
	Route::post('api/changepassword', array('uses' => 'MobileController@changePassword'));
	Route::post('api/assessment', array('uses' => 'MobileController@showPunctualityAssessment'));
	Route::post('api/fileleave', array('uses' => 'MobileController@fileALeave'));
	Route::post('api/accumulated', array('uses' => 'MobileController@showAccumulatedHours'));

	Route::group(["before" => "auth"], function() {


		Route::get('report/dtr', array('uses' => 'HomeController@showPdfreportsdtr'));
		Route::get('report/hierarchy', array('uses' => 'HomeController@showPdfreportshierarchy'));
		Route::get('report/branch', array('uses' => 'HomeController@showPdfreportsbranch'));
		Route::get('report/department', array('uses' => 'HomeController@showPdfreportsdepartment'));
		Route::get('report/assessment', array('uses' => 'HomeController@showPdfAssessment'));
		Route::get('report/leavecases', array('uses' => 'HomeController@postPdfreportsleave'));
		Route::get('report/accumulated', array('uses' => 'HomeController@showAccumulatedDanceCraze'));
		Route::resource('maintenance','HomeController@showMaintenance');
		Route::resource('transaction','HomeController@showTransaction');
		Route::resource('query','HomeController@showQuery');
		Route::resource('report','HomeController@showReport');
		Route::resource('utility','HomeController@showUtility');
		Route::resource('dashboard', 'HomeController@showDashboard');
		Route::resource('branches', 'BranchesController');
		Route::resource('stations', 'StationsController');
		Route::resource('custom_assign_overtimes', 'Custom_assign_overtimesController');
		Route::resource('departments', 'DepartmentsController');
		Route::resource('request_types', 'Request_typesController');
		Route::resource('attendances', 'AttendancesController');
		Route::resource('hierarchies', 'HierarchiesController');
		Route::resource('holiday_policies', 'Holiday_policiesController');
		Route::resource('overtime_policies', 'Overtime_policiesController');
		Route::resource('contracts', 'ContractsController');
		Route::resource('break_policies', 'Break_policiesController');
		Route::resource('premium_policies', 'Premium_policiesController');
		Route::resource('policy_groups', 'Policy_groupsController');
		Route::resource('exception_policies', 'Exception_policiesController');
		Route::resource('stations', 'StationsController');
		Route::resource('accrual_policies', 'Accrual_policiesController');
		Route::resource('contracts', 'ContractsController');
		Route::resource('companies', 'CompaniesController');
		Route::resource('jobtitles', 'JobtitlesController');
		Route::resource('schedules', 'SchedulesController');
		Route::resource('employs', 'EmploysController');
		Route::post("employs/search", array(
			'as' => 'employs.search',
			'uses' => 'EmploysController@postSearch'
		));
		
		Route::resource('exception_groups', 'Exception_groupsController');
		Route::resource('assign_exceptions', 'Assign_exceptionsController');
		Route::resource('leave_grants', 'Leave_grantsController');
		Route::resource('pay_periods', 'PayPeriodsController');
		Route::resource('credit_policies', 'Credit_policiesController');
		Route::resource('empschedules', 'EmpschedulesController');
		Route::resource('assign_overtimes','Assign_overtimesController');
		Route::get('queries/dtr','HomeController@showManual');
		Route::post('queries/dtr', array('uses' => 'HomeController@postManual'));
		
		Route::post('queries/dtr_adjusted', function()
		 { if(Input::get('Change')) { $action = 'postManualAdjust'; }
		 elseif(Input::get('Delete')) { $action = 'postManualDelete'; } 
			return App::make('HomeController')->$action(); });

		Route::get('emp_schedules/remove', array('uses' => 'EmpschedulesController@removeFromSched'));
		Route::get('transactions/assign_hierarchy', array('uses' => 'HierarchiesController@assignSubordinates'));
		Route::post('transactions/assign_hierarchy', array('uses' => 'HierarchiesController@postAssignSubordinates'));
		Route::post('emp_schedules/remove', array('uses' => 'EmpschedulesController@postRemoveFromSched'));
		Route::get('transactions/edit_dtr', array('uses' => 'HomeController@showEditDtr'));
		Route::post('transaction', array('uses' => 'EmpschedulesController@delEmployeeFromSched'));
		Route::post('schedules/assign_employee', array('uses' => 'SchedulesController@addExtraEmployees'));
		Route::post('schedules/remove_employee', array('uses' => 'SchedulesController@removeEmployees'));
		Route::post('hierarchies/remove_employee', array('uses' => 'HierarchiesController@removeSubordinate'));
		Route::post('policy_groups/assign_policy', array('uses' => 'Policy_groupsController@addExtraSubordinates'));
		Route::post('policy_groups/remove_employee', array('uses' => 'Policy_groupsController@removeSubordinate'));
		Route::post('hierarchies/index', array('uses' => 'HierarchiesController@postindex'));
		Route::post('queries/empbydept', array('uses' => 'HomeController@postshowQueryEmpbydept'));
		Route::post('queries/empbybranch', array('uses' => 'HomeController@postshowQueryEmpbybranch'));
		Route::post('queries/leavecases', array('uses' => 'HomeController@postshowLeaveCases'));
		Route::resource('assign_overtimes', 'Assign_overtimesController');
		Route::resource('overtime_subordinates', 'Overtime_subordinatesController');
		Route::resource('empbydept', 'HomeController@showQueryEmpbydept');
		Route::resource('empbybranch', 'HomeController@showQueryEmpbybranch');
		Route::resource('downloads', 'DownloadsController');
		Route::resource('leavecredits', 'HomeController@showLeaveCredit');
		Route::resource('leave_query', 'HomeController@showLeaveQuery');
		Route::resource('empsummary', 'HomeController@showEmpSummary');
		Route::post('leavededuct', array('uses' => 'HomeController@LeaveDeduct'));
		Route::post('deduct', array('uses' => 'HomeController@Deduct'));
		Route::resource('approved_leave', 'HomeController@showApproved');
		Route::resource('empdownloads', 'EmpdownloadsController');
		Route::resource('leavecases', 'HomeController@showLeaveCases');
		Route::post('leavesummary', array('uses' => 'HomeController@postLeaveSummary'));
		Route::post('addsubordinates', array('uses' => 'HierarchiesController@addSubordinates'));
		Route::post('removesubordinates', array('uses' => 'HierarchiesController@removeSubordinates'));
		Route::post('postaccumulatedhours', array('uses' => 'HomeController@postshowAccumulatedHoursAdmin'));
		Route::post('postpunctualityassessment', array('uses' => 'HomeController@postshowPunctualityAssessmentAdmin'));
		Route::resource('absent_employee', 'HomeController@showAbsent');
		Route::resource('accumulatedhours', 'HomeController@showAccumulatedHoursAdmin');
		Route::resource('punctualityassessment', 'HomeController@showPunctualityAssessmentAdmin');
		Route::post('absent_employee', array('uses' => 'HomeController@postAbsent'));
	 
		Route::post('exception/edit', function()
		 { if(Input::has('Edit')) { $action = 'postEdit'; }
		 elseif(Input::has('Delete')) { $action = 'postDelete'; }
		 elseif(Input::has('Update')) { $action = 'postUpdate'; } 
		 elseif(Input::has('Add')) { $action = 'postAdd'; } 
		 elseif(Input::has('Insert')) { $action = 'postInsert'; } 
			return App::make('Exception_policiesController')->$action(); });
	});

?>





