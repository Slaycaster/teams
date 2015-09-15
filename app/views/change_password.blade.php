@extends("layout")
@section("content")
	<br><br><br>
	<div class = "container">
		<div class = "row">
            {{ Form::open(array('url'=>'change_password', 'class'=>'block small center login')) }}
    <h3 class="">Change Password</h3>
       <h6 style="color:white;">Please change your password below.</h6>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            @if (Session::has('changepw_error'))
                <div class="alert alert-danger">{{ Session::get('changepw_error') }}</div>
            @endif
            @if (Session::has('changepw_success'))
                <div class="alert alert-info">{{ Session::get('changepw_success') }}</div>
            @endif
        </ul>

        {{ Form::password('old_password', array('class'=>'input-block-level', 'placeholder'=>'Old Password')) }}<br><br>
        {{ Form::password('new_password', array('class'=>'input-block-level', 'placeholder'=>'New Password')) }}<br><br>
        {{ Form::password('password_again', array('class'=>'input-block-level', 'placeholder'=>'Confirm New Password')) }}<br><br>


        {{ Form::submit('Submit', array('class'=>'k-button'))}}
         {{ Form::close() }}
		</div>
    </div>

    <div class = "container" style = "position: fixed; bottom: 0px; width: 100%;    height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
            <p style = "color:white;">Copyright &copy; pending. Fare Matrix</p>
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