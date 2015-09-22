@extends("layout_employee")
@section("content")

	<br><br><br>
	<div class = "container">
		<div class = "row">
			<div class = "col-md-1" style = "margin-top:20px;">
				<img src="{{ URL::asset('img/home.png') }}">
			</div>
			<div class = "col-md-2" >
				<h1 style = "color:white;">Dashboard</h1>
			</div>
		</div>

		<br>
		<br>

		<div class = "row">
			<div class = "col-md-6">
			<a href="leave_credits">
				<div class = "col-md-3 greentile" style="height:97px">
						<center><span class ="glyphicon glyphicon-home" style="font-size:50px; margin-top:20px"></span></span></center>
						
				</div>
				<div class = "col-md-9 greytile" >
					<br>
					<center><h3 style = "color:white; margin-bottom:12px">Leave Credits</h3></center>
					<br>
				</div>
		
			</a>
			</div>
			@foreach($supervisor as $supervisors)
                                @if( $supervisors->supervisor_id == $id)
            <div class = "col-md-6">
			<a href="requests_authorization">
				<div class = "col-md-3 greentile" style="height:97px">
						<center><span class ="glyphicon glyphicon-home" style="font-size:50px; margin-top:20px"></span></span></center>
						
				</div>
				<div class = "col-md-9 greytile" >
					<br>
					<center><h3 style = "color:white; margin-bottom:12px">{{$count}}  Pending Leave  Requests</h3></center>
					<br>
				</div>
		
			</a>
			</div>
			@endif
			@endforeach
	</div>
     </div>
		

<script type="text/javascript">
    $(function(){
    $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
    
</script>
@stop