<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();


		$this->call('UserTableSeeder');
		$this->call('Holiday_policiesTableSeeder');
		$this->call('BranchesTableSeeder');
		$this->call('StationsTableSeeder');
		$this->call('AttendancesTableSeeder');
		$this->call('DepartmentsTableSeeder');
		$this->call('RequestsTableSeeder');
		$this->call('Request_typesTableSeeder');
		$this->call('Create_requestsTableSeeder');
		$this->call('SchedulesTableSeeder');
		$this->call('ContractsTableSeeder');
		$this->call('HierarchiesTableSeeder');
		$this->call('Overtime_policiesTableSeeder');
		$this->call('Accrual_policiesTableSeeder');
		$this->call('Break_policiesTableSeeder');
		$this->call('Premium_policiesTableSeeder');
		$this->call('Exception_policiesTableSeeder');
		$this->call('Policy_groupsTableSeeder');
		$this->call('EmployeesTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('CompaniesTableSeeder');
		$this->call('JobtitlesTableSeeder');
		$this->call('EmploysTableSeeder');
		$this->call('Exception_groupsTableSeeder');
		$this->call('Assign_exceptionsTableSeeder');
		$this->call('Leave_grantsTableSeeder');
		$this->call('Create_table_empschedulesTableSeeder');
		$this->call('EmpschedulesTableSeeder');
		$this->call('Credit_policiesTableSeeder');
		$this->call('InfotechsTableSeeder');
		$this->call('ItechsTableSeeder');
		$this->call('BreaksTableSeeder');
		$this->call('LevelsTableSeeder');
		$this->call('Assign_overtimesTableSeeder');
		$this->call('Overtime_subordinatesTableSeeder');
		$this->call('Custom_overtimesTableSeeder');
		$this->call('Custom_assign_overtimesTableSeeder');
		$this->call('DownloadsTableSeeder');
		$this->call('Leave_creditsTableSeeder');
		$this->call('LeavecreditsTableSeeder');
		$this->call('EmployeefilesTableSeeder');
		$this->call('EmpdownloadsTableSeeder');
		$this->call('LeavesummariesTableSeeder');
		$this->call('Branches_holidaysTableSeeder');
	}

}
