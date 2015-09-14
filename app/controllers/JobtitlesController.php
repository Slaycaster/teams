<?php

class JobtitlesController extends BaseController {

	/**
	 * Jobtitle Repository
	 *
	 * @var Jobtitle
	 */
	protected $jobtitle;

	public function __construct(Jobtitle $jobtitle)
	{
		$this->jobtitle = $jobtitle;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$jobtitles = Jobtitle::paginate(9);

		return View::make('jobtitles.index', compact('jobtitles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('jobtitles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Jobtitle::$rules);

		if ($validation->passes())
		{
			$this->jobtitle->create($input);

			return Redirect::route('jobtitles.index');
		}

		return Redirect::route('jobtitles.index')
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
		$jobtitle = $this->jobtitle->findOrFail($id);

		return View::make('jobtitles.show', compact('jobtitle'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$jobtitle = $this->jobtitle->find($id);

		if (is_null($jobtitle))
		{
			return Redirect::route('jobtitles.index');
		}

		return View::make('jobtitles.edit', compact('jobtitle'));
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
		$validation = Validator::make($input, Jobtitle::$rules);

		if ($validation->passes())
		{
			$jobtitle = $this->jobtitle->find($id);
			$jobtitle->update($input);

			return Redirect::route('jobtitles.index', $id);
		}

		return Redirect::route('jobtitles.index', $id)
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
		$this->jobtitle->find($id)->delete();

		return Redirect::route('jobtitles.index');
	}

}
