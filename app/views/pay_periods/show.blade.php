@extends('layout-noheader')
@section('content')

<head>
	<title>Show Pay Period |  Time and Attendance Monitoring System</title>
</head>

<h1>Showing {{ $pay_period->name }}</h1>

<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('pay_periods') }}" class="btn btn-default">Pay Periods</a>
            <a class="btn btn-default">{{$pay_period->name}}</a>
</div>

    <div class="jumbotron text-center">
        <h2>{{ $pay_period->name }}</h2>
        <p>
            <strong>Name:</strong> {{ $pay_period->name }}<br>
            <strong>Description:</strong> {{ $pay_period->description }}<br>
            <strong>Type:</strong> {{ $pay_period->type }}<br>
            <strong>Pay Period Day:</strong> {{ $pay_period->payperiod_day }}<br>
            <strong>Initial Pay Period Date:</strong> {{ $pay_period->initial_payperiod }}
            <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
        </p>
    </div>

@stop