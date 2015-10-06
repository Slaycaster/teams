@extends("layout_employee")
@section("content")
	<br><br><br>
	<div class = "container">
		<div class = "row">
            {{ Form::open(array('url'=>'change_password', 'class'=>'block small center login')) }}
    <h1 class="">Change Password</h1><br>
       <h4 style="color:white;">Confirm changing your password by filling up below.</h4>
       <hr>
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
        <div style = "font-size:16px;">
            {{ Form::label('old_password', 'Old Password:', array('style' => 'color:white;'))}}
            {{ Form::password('old_password', array('placeholder'=>'Old Password')) }}<br><br>
            {{ Form::label('new_password', 'New Password:', array('style' => 'color:white;'))}}
            {{ Form::password('new_password', array('placeholder'=>'New Password')) }}<br><br>
            {{ Form::label('password_again', 'Confirm New Password:', array('style' => 'color:white;'))}}
            {{ Form::password('password_again', array('placeholder'=>'Confirm New Password')) }}<br><br>
        </div>

        {{ Form::submit('Submit', array('class'=>'btn btn-primary'))}}
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