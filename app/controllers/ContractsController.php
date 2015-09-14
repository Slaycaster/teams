<?php

class ContractsController extends BaseController {

	/**
	 * Contract Repository
	 *
	 * @var Contract
	 */
	protected $contract;

	public function __construct(Contract $contract)
	{
		$this->contract = $contract;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$contracts = Contract::paginate(9);

		return View::make('contracts.index', compact('contracts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('contracts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Contract::$rules);

		if ($validation->passes())
		{
			$this->contract->create($input);

			return Redirect::route('contracts.index');
		}

		return Redirect::route('contracts.index')
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
		$contract = $this->contract->findOrFail($id);

		return View::make('contracts.show', compact('contract'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$contract = $this->contract->find($id);

		if (is_null($contract))
		{
			return Redirect::route('contracts.index');
		}

		return View::make('contracts.edit', compact('contract'));
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
		$validation = Validator::make($input, Contract::$rules);

		if ($validation->passes())
		{
			$contract = $this->contract->find($id);
			$contract->update($input);

			return Redirect::route('contracts.show', $id);
		}

		return Redirect::route('contracts.edit', $id)
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
		$this->contract->find($id)->delete();

		return Redirect::route('contracts.index');
	}

}
