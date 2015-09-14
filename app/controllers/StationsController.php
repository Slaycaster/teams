<?php

class StationsController extends BaseController {

	/**
	 * Station Repository
	 *
	 * @var Station
	 */
	protected $station;

	public function __construct(Station $station)
	{
		$this->station = $station;
		
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$stations = Station::paginate(9);
		$branches = DB::table('branches')->get();
		$branches_id = DB::table('branches')
		->lists('branch_name', 'id');

		return View::make('stations.index', compact('stations'))
		->with('stations', $stations)
		->with('branches', $branches)
		->with('branches_id', $branches_id);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$branches = DB::table('branches')
		->lists('branch_name', 'id');
		return View::make('stations.create')
		->with('branches', $branches);
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Station::$rules);

		if ($validation->passes())
		{
			$this->station->create($input);

			return Redirect::route('stations.index');
		}

		return Redirect::route('stations.index')
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
		$station = $this->station->findOrFail($id);
		$branches = DB::table('branches')->get();
		return View::make('stations.show', compact('station'))
		->with('branches', $branches);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$station = $this->station->find($id);
		$branches = DB::table('branches')
		->lists('branch_name', 'id');

		if (is_null($station))
		{
			return Redirect::route('stations.index');
		}

		return View::make('stations.edit', compact('station'))
		->with('branches', $branches);
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
		$validation = Validator::make($input, Station::$rules);

		if ($validation->passes())
		{
			$station = $this->station->find($id);
			$station->update($input);

			return Redirect::route('stations.index', $id);
		}

		return Redirect::route('stations.index', $id)
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
		$this->station->find($id)->delete();

		return Redirect::route('stations.index');
	}

}
