<?php

class DownloadsController extends BaseController {

	/**
	 * Download Repository
	 *
	 * @var Download
	 */
	protected $download;

	public function __construct(Download $download)
	{
		$this->download = $download;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$downloads = Download::paginate(9);

		return View::make('downloads.index', compact('downloads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('downloads.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$id = DB::table('downloads')->max('id');
		$id = $id + 1;
		$input = Input::all();
		$validation = Validator::make($input, Download::$rules);
		$file = array('pdf' => Input::file('path'));

		if ($validation->passes())
		{
			$destinationPath = 'forms'; //upload path
			$extension = Input::file('path')->getClientOriginalExtension();
			$fileName =  Input::get('file_name').'.'.$extension; 
			Input::file('path')->move($destinationPath, $fileName);

			$download = new Download;
			$download->file_name = Input::get('file_name');
			$download->path = 'forms/'."".Input::get('file_name')."".'.pdf';
			$download->save();


			return Redirect::route('downloads.index');
		}

		return Redirect::route('downloads.index')
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
		$download = $this->download->findOrFail($id);

		return View::make('downloads.show', compact('download'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$download = $this->download->find($id);

		if (is_null($download))
		{
			return Redirect::route('downloads.index');
		}

		return View::make('downloads.edit', compact('download'));
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
		$validation = Validator::make($input, Download::$rules);

		if ($validation->passes())
		{
			$download = $this->download->find($id);
			$download->update($input);

			return Redirect::route('downloads.show', $id);
		}

		return Redirect::route('downloads.edit', $id)
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
		$this->download->find($id)->delete();

		return Redirect::route('downloads.index');
	}

}
