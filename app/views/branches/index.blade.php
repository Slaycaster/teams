@extends("layout")
@section("content")

<head>
    <title>Branches | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12">
<h1>Branch Maintenance</h1>
	<div class ="col-md-4">
    {{ $branches->links() }}
  </div>
	
</div>


<div class="container" style="margin-top:30px">
  <div class = "row">
    <div class = "col-md-4">
      <h3>Add a Branch</h3><hr>
            {{ Form::open(array('route' => 'branches.store')) }}

                
                <div class="label_white">
                    {{ Form::label('branch_name', 'Branch Name:')}}</div>
                    {{ Form::text('branch_name', Input::get('branch_name'), array('placeholder' => 'Branch name','autocomplete' => 'off', 'size' => '40')) }}<br>

                <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
                {{ Form::select('status', array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}<br>

                <div class="label_white">{{ Form::label('code', 'Code:') }}</div>
                {{ Form::text('code', Input::get('code'), array('placeholder' => 'Code','autocomplete' => 'off', 'size' => '40')) }}<br>

                <div class="label_white">{{ Form::label('address', 'Address:') }}</div>
                {{ Form::text('address', Input::get('address'), array('placeholder' => 'Address','autocomplete' => 'off', 'size' => '40')) }}<br>
                
                <div class="label_white">{{ Form::label('city', 'City:') }}</div>
                {{ Form::text('city', Input::get('city'), array('placeholder' => 'City','autocomplete' => 'off', 'size' => '40')) }}<br>
     
                <div class="label_white">{{ Form::label('country', 'Country:') }}</div>
                {{ Form::text('country', Input::get('country'), array('placeholder' => 'Country','autocomplete' => 'off', 'size' => '40')) }}<br>
     
              

                <div class="label_white">{{ Form::label('email', 'Email:') }}</div>
                {{ Form::text('email', Input::get('email'), array('placeholder' => 'Email','autocomplete' => 'off', 'size' => '40')) }}

                <br><br>
                {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </ul>
    {{ Form::close() }}
    </div>
    <div class = "col-md-8">
      <h3>All Branches</h3><hr>
      @foreach ($branches as $branch)

      <div class="col-md-5" style="margin-bottom:5px">
        <div class="col-md-12 greytile" style="padding:5px">
          <div class="col-md-5" >
               <img style = "height:80px; width:80px; margin-top:15px" src="{{ URL::asset('img/Branches.png') }}">
          </div>
          <div class="col-md-7" style="margin-left:0px">

               <p style="color:white; font-size:14px"> <strong>{{$branch->branch_name}}</strong>
                @if ($branch->status == 'Enabled')
                <img style = "height:20px; width:20px;" src="{{ URL::asset('img/Check.png') }}">
                @else
              <img style = "height:20px; width:20px;" src="{{ URL::asset('img/Wrong.png') }}">
              @endif</p>                    
           
               <p style="color:white; font-size:12px"> {{$branch->address}}</p>
               <p style="color:white; font-size:12px"> {{$branch->country}}</p>
               <a href="{{ URL::to('branches/' . $branch->id) }}" onclick="window.open('{{ URL::to('branches/' . $branch->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('branches/' . $branch->id . '/edit') }}" onclick="window.open('{{ URL::to('branches/' . $branch->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
           </div>

         </div>
      </div>
      @endforeach
    </div>
  </div>
   
</div>

@stop
