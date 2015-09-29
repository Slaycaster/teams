@extends('layout')
@section('content')

<head>
    <title>Reports | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Reports Leave Cases </h1>

<div class='col-md-6'>
<h3>Select Month</h3>
{{ Form::open(array('url' => 'report/leavecases', 'method' => 'post')) }}
	 {{ Form::selectMonth('month');}}<br><br>
</div>
<div class='col-md-6'>
<h3>Select Year</h3>
{{ Form::open(array('url' => 'report/leavecases', 'method' => 'post')) }}
	 {{ Form::selectYear('year', 2015, 1960)}}<br><br>
</div>
{{ Form::submit('Generate PDF', array('class' => 'btn btn-success')) }}
{{ Form::close() }}
@stop