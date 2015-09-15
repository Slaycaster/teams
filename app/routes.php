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
	Route::get('sampol', array('uses' => 'HomeController@showPdfreports'));
	Route::get('logout', array('uses' => 'HomeController@doLogout'));
	Route::post('logout', array('uses' => 'HomeController@doLogout'));
	Route::get('employee/timesheet', array('uses' => 'EmployeeLoginController@showTimeSheet'));
	Route::get('employee/timesheet/table', array('uses' => 'EmployeeLoginController@showTimeSheetTable'));
	Route::get('employee/timesheet/graph', array('uses' => 'EmployeeLoginController@showTimeSheetGraph'));
	Route::get('employee/timesheet/dtr', array('uses' => 'EmployeeLoginController@showTimeSheetDtr'));
	Route::get('employee/accumulated_hours', array('uses' => 'EmployeeLoginController@showAccumulatedHours'));
	Route::get('employee/exceptions', array('uses' => 'EmployeeLoginController@showExceptions'));
	Route::get('employee/accruals', array('uses' => 'EmployeeLoginController@showAccruals'));
	Route::get('employee/requests_authorization', array('uses' => 'EmployeeLoginController@showRequestsAuthorization'));
	Route::post('employee/requests_authorized', array('uses' => 'EmployeeLoginController@postRequestsAuthorization'));
	Route::get('employee/attendance', array('uses' => 'AttendanceLoginController@showLogin'));
	Route::post('employee/attendance', array('uses' => 'AttendanceLoginController@doLogin'));
	Route::resource('create_requests', 'Create_requestsController');
	Route::resource('itechs', 'ItechsController');
	Route::resource('levels', 'LevelsController');
	Route::post('change_password', array('uses' => 'EmployeeLoginController@changePassword'));
	Route::get('employee/change_password', array('uses' => 'EmployeeLoginController@showChangePassword'));
	Route::get('employee/dailytimerecord','EmployeeLoginController@showDTR');
	Route::get('employee/downloads', array('uses' => 'EmployeeLoginController@showDownload'));
	Route::get('employee/leave_credits', array('uses' => 'EmployeeLoginController@showLeaveCredit'));
	Route::get('employee/employeesummary', array('uses' => 'EmployeeLoginController@showEmployeeSummary'));

	//Route::any('dashboard', array('uses' => 'HomeController@showDashboard'));

	//Route::get('maintenance', array('uses' => 'HomeController@showMaintenance'));

	Route::group(["before" => "auth"], function() {


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
		Route::get('emp_schedules/remove', array('uses' => 'EmpschedulesController@removeFromSched'));
		Route::get('transactions/assign_hierarchy', array('uses' => 'HierarchiesController@assignSubordinates'));
		Route::post('transactions/assign_hierarchy', array('uses' => 'HierarchiesController@postAssignSubordinates'));
		Route::post('emp_schedules/remove', array('uses' => 'EmpschedulesController@postRemoveFromSched'));
		Route::post('transaction', array('uses' => 'EmpschedulesController@delEmployeeFromSched'));
		Route::post('schedules/assign_employee', array('uses' => 'SchedulesController@addExtraEmployees'));
		Route::post('schedules/remove_employee', array('uses' => 'SchedulesController@removeEmployees'));
		Route::post('hierarchies/remove_employee', array('uses' => 'HierarchiesController@removeSubordinate'));
		Route::post('policy_groups/assign_policy', array('uses' => 'Policy_groupsController@addExtraSubordinates'));
		Route::post('policy_groups/remove_employee', array('uses' => 'Policy_groupsController@removeSubordinate'));
		Route::post('hierarchies/index', array('uses' => 'HierarchiesController@postindex'));
		Route::post('queries/empbydept', array('uses' => 'HomeController@postshowQueryEmpbydept'));
		Route::post('queries/empbybranch', array('uses' => 'HomeController@postshowQueryEmpbybranch'));
		Route::resource('assign_overtimes', 'Assign_overtimesController');
		Route::resource('overtime_subordinates', 'Overtime_subordinatesController');
		Route::resource('empbydept', 'HomeController@showQueryEmpbydept');
		Route::resource('empbybranch', 'HomeController@showQueryEmpbybranch');
		Route::resource('downloads', 'DownloadsController');
		Route::resource('leavecredits', 'HomeController@showLeaveCredit');
		Route::resource('empsummary', 'HomeController@showEmpSummary');
		Route::post('leavededuct', array('uses' => 'HomeController@LeaveDeduct'));
		Route::resource('approved_leave', 'HomeController@showApproved');
	});

?>




