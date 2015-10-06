<?php

class EmpdownloadsController extends BaseController {

	/**
	 * Empdownload Repository
	 *
	 * @var Empdownload
	 */
	protected $empdownload;

	public function __construct(Empdownload $empdownload)
	{
		$this->empdownload = $empdownload;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$empdownloads = Empdownload::paginate(9);
		$employees = DB::table('employs')->join('empdownloads', 'employs.id', '=', 'empdownloads.employee_id')->get();
		$employee_id = Employ::select(DB::raw('concat(lname, ", ", fname) as full_name'), 'id' )->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('empdownloads.index', compact('empdownloads'))
		->with('employee_id', $employee_id)
		->with('employees', $employees);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('empdownloads.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$id = DB::table('empdownloads')->max('id');
		$id = $id + 1;
		$input = Input::all();
		$validation = Validator::make($input, Download::$rules);
		$file = array('pdf' => Input::file('path'));

		if ($validation->passes())
		{
			$destinationPath = 'employee_files'; //upload path
			$extension = Input::file('path')->getClientOriginalExtension();
			$fileName =  Input::get('file_name').'.'.$extension; 
			Input::file('path')->move($destinationPath, $fileName);

			$empdownload = new Empdownload;
			$empdownload->employee_id = Input::get('employee_id');
			$empdownload->file_name = Input::get('file_name');
			$empdownload->path = 'employee_files/'."".Input::get('file_name')."".'.pdf';
			$empdownload->save();


			return Redirect::route('empdownloads.index');
		}

		return Redirect::route('empdownloads.index')
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
		$empdownload = $this->empdownload->findOrFail($id);
		$employee = DB::table('employs')->where('id', '=', $empdownload->employee_id)->get();
		return View::make('empdownloads.show', compact('empdownload'))
		->with('employee', $employee);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$empdownload = $this->empdownload->find($id);

		if (is_null($empdownload))
		{
			return Redirect::route('empdownloads.index');
		}

		return View::make('empdownloads.edit', compact('empdownload'));
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
		$validation = Validator::make($input, Empdownload::$rules);

		if ($validation->passes())
		{
			$empdownload = $this->empdownload->find($id);
			$empdownload->update($input);

			return Redirect::route('empdownloads.show', $id);
		}

		return Redirect::route('empdownloads.edit', $id)
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
		$this->empdownload->find($id)->delete();

		return Redirect::route('empdownloads.index');
	}

}
