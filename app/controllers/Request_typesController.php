<?php

class Request_typesController extends BaseController {

	/**
	 * Request_type Repository
	 *
	 * @var Request_type
	 */
	protected $request_type;

	public function __construct(Request_type $request_type)
	{
		$this->request_type = $request_type;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
		$request_types=Request_type::paginate(9);
		

		return View::make('request_types.index', compact('request_types'));
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return View::make('request_types.index');
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Request_type::$rules);

		if ($validation->passes())
		{
			$this->request_type->create($input);

			return Redirect::route('request_types.index');
		}

		return Redirect::route('request_types.index')
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
		$request_type = $this->request_type->findOrFail($id);

		return View::make('request_types.show', compact('request_type'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$request_type = $this->request_type->find($id);

		if (is_null($request_type))
		{
			return Redirect::route('request_types.index');
		}

		return View::make('request_types.edit', compact('request_type'));
		
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
		$validation = Validator::make($input, Request_type::$rules);

		if ($validation->passes())
		{
			$request_type = $this->request_type->find($id);
			$request_type->update($input);

			return Redirect::route('request_types.index', $id);
		}

		return Redirect::route('request_types.index', $id)
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
		$this->request_type->find($id)->delete();

		return Redirect::route('request_types.index');
	}

}
