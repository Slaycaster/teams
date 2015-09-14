@extends("layout")
@section("content")

<head>
    <title>Job titles | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px">
<h1>Job title Maintenance</h1>

<div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Job Titles</a>
        </div>
  </div>

  

	<div class="col-md-4">
    {{ $jobtitles->links() }}
  </div>
</div>


<div class="container" style="margin-top:20px" style = "margin-left: -10%">
    <div class = "row">
          <div class = "col-md-5" style = "margin-left: -3%">
              <h3 style = "margin-left: 8%">Add a Job title</h3>
              @if ($errors->any())
              <ul>
                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
              </ul>
              @endif

                {{ Form::open(array('route' => 'jobtitles.store')) }}
                  <ul>
                        
                           <div class="label_white"> {{ Form::label('jobtitle_name', 'Job title:') }}</div>
                            {{ Form::text('jobtitle_name', Input::get('jobtitle_name'), array('placeholder' => 'Job title','autocomplete' => 'off', 'size' => '40')) }}<br>
                        
                            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                            {{ Form::textarea('description') }}<br>
                        
                      {{ Form::submit('Submit', array('class' => 'btn btn-info')  ) }}
                    
                  </ul>
                {{ Form::close() }}
          </div>
          <div class = "col-md-7">
          <h3>All Job titles</h3>
			       @foreach ($jobtitles as $jobtitle)
             <div class="col-md-6" style="margin-bottom:15px">
                  <div class="col-md-12 greytile" style="padding:4px; height:140px;">
                      <div class="col-md-7" >
                          <img style = "height:70px; width:70px;" src="{{ URL::asset('img/Department.png') }}">
                      </div>
                      <div class="col-md-5" style="margin-left:-30px">
                          <p style="color:white; font-size:14px"> {{$jobtitle->jobtitle_name}}</p>                    
                          <p style="color:white; font-size:12px"> <strong>{{$jobtitle->description}}</strong></p>
                          <a href="{{ URL::to('jobtitles/' . $jobtitle->id) }}" onclick="window.open('{{ URL::to('jobtitles/' . $jobtitle->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('jobtitles/' . $jobtitle->id . '/edit') }}" onclick="window.open('{{ URL::to('jobtitles/' . $jobtitle->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                      </div>
                  </div>
             </div>
             @endforeach
          </div>
    </div>
</div>

@stop
