<?php

use Mockery as m;
use Way\Tests\Factory;

class CustomAssignOvertimesTest extends TestCase {

	public function __construct()
	{
		$this->mock = m::mock('Eloquent', 'Custom_assign_overtime');
		$this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
	}

	public function setUp()
	{
		parent::setUp();

		$this->attributes = Factory::custom_assign_overtime(['id' => 1]);
		$this->app->instance('Custom_assign_overtime', $this->mock);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testIndex()
	{
		$this->mock->shouldReceive('all')->once()->andReturn($this->collection);
		$this->call('GET', 'custom_assign_overtimes');

		$this->assertViewHas('custom_assign_overtimes');
	}

	public function testCreate()
	{
		$this->call('GET', 'custom_assign_overtimes/create');

		$this->assertResponseOk();
	}

	public function testStore()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(true);
		$this->call('POST', 'custom_assign_overtimes');

		$this->assertRedirectedToRoute('custom_assign_overtimes.index');
	}

	public function testStoreFails()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(false);
		$this->call('POST', 'custom_assign_overtimes');

		$this->assertRedirectedToRoute('custom_assign_overtimes.create');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testShow()
	{
		$this->mock->shouldReceive('findOrFail')
				   ->with(1)
				   ->once()
				   ->andReturn($this->attributes);

		$this->call('GET', 'custom_assign_overtimes/1');

		$this->assertViewHas('custom_assign_overtime');
	}

	public function testEdit()
	{
		$this->collection->id = 1;
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->once()
				   ->andReturn($this->collection);

		$this->call('GET', 'custom_assign_overtimes/1/edit');

		$this->assertViewHas('custom_assign_overtime');
	}

	public function testUpdate()
	{
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->andReturn(m::mock(['update' => true]));

		$this->validate(true);
		$this->call('PATCH', 'custom_assign_overtimes/1');

		$this->assertRedirectedTo('custom_assign_overtimes/1');
	}

	public function testUpdateFails()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['update' => true]));
		$this->validate(false);
		$this->call('PATCH', 'custom_assign_overtimes/1');

		$this->assertRedirectedTo('custom_assign_overtimes/1/edit');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testDestroy()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['delete' => true]));

		$this->call('DELETE', 'custom_assign_overtimes/1');
	}

	protected function validate($bool)
	{
		Validator::shouldReceive('make')
				->once()
				->andReturn(m::mock(['passes' => $bool]));
	}
}
