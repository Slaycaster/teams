@extends("layout")
@section("content")

<head>
    <title>Downloadables | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-top:-20px; margin-bottom:15px">
<h1>Forms Maintenance</h1>

	<div class ="col-md-6">
    {{ $downloads->links() }}
  </div>
	
</div>


<div class="container" style="margin-top:30px">
  <div class = "row">
    <div class = "col-md-4">
      <h3>Upload Form</h3>
      @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
           {{ Form::open(array('route' => 'downloads.store', 'files' => true)) }}

                
                <div class="label_white">
                    {{ Form::label('file_name', 'File Name:')}}</div>
                    {{ Form::text('file_name', Input::get('file_name'), array('placeholder' => 'File name','autocomplete' => 'off', 'size' => '40')) }}<br>

               <div class="label_white">{{ Form::label('path', 'Choose pdf file:') }}</div>
                {{ Form::file('path') }}<br>

                <br><br>
                 {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </ul>
    {{ Form::close() }}
    </div>
    <div class = "col-md-8">
      <h3 styles="margin-left:100px">All Forms</h3>
      @foreach ($downloads as $download)

      <div class="col-md-4" style="margin-bottom:5px">
        <div class="col-md-12 greytile" style="padding:5px">
          <div class="col-md-5" >
               <img style = "height:100px; width:100px;" src="{{ URL::asset('img/Kiosk.png') }}">
          </div>
          <div class="col-md-7" style="margin-left:0px">     
           
               <p style="color:white; font-size:12px"> {{$download->file_name}}</p>
               <p style="color:white; font-size:12px"> {{$download->path}}</p>
               <a href="{{ URL::to('downloads/' . $download->id) }}" onclick="window.open('{{ URL::to('downloads/' . $download->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('downloads/' . $download->id . '/edit') }}" onclick="window.open('{{ URL::to('downloads/' . $download->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
           </div>

         </div>
      </div>
      @endforeach
    </div>
  </div>
   
</div>

@stop
