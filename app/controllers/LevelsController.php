<?php

class LevelsController extends BaseController {

	/**
	 * Level Repository
	 *
	 * @var Level
	 */
	protected $level;

	public function __construct(Level $level)
	{
		$this->level = $level;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$levels = Level::paginate(9);

		return View::make('levels.index', compact('levels'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('levels.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Level::$rules);

		if ($validation->passes())
		{
			$this->level->create($input);

			return Redirect::route('levels.index');
		}

		return Redirect::route('levels.create')
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
		$level = $this->level->findOrFail($id);

		return View::make('levels.show', compact('level'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$level = $this->level->find($id);

		if (is_null($level))
		{
			return Redirect::route('levels.index');
		}

		return View::make('levels.edit', compact('level'));
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
		$validation = Validator::make($input, Level::$rules);

		if ($validation->passes())
		{
			$level = $this->level->find($id);
			$level->update($input);

			return Redirect::route('levels.show', $id);
		}

		return Redirect::route('levels.edit', $id)
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
		$this->level->find($id)->delete();

		return Redirect::route('levels.index');
	}

}
