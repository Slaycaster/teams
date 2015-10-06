@extends("layout_employee")
@section("content")

<head>
    <title>Employee Files | Time and Electronic Attendance Monitoring System</title>
</head>
        <div class="container">
        <br><br><br>
        <h2 styles="margin-left:100px">Your Files</h2><br>
        @foreach ($empdownloads as $empdownload)

      <div class="col-md-5" style="margin-bottom:5px">
        <div class="col-md-12 greytile" style="padding:5px">
          <div class="col-md-5" >
               <img style = "height:80px; width:80px;" src="{{ URL::asset('img/Download.png') }}">
          </div>
           {{ Form::open(array('url' => 'employee/empdownloadshow', 'method' => 'post', 'autocomplete' => 'off')) }}    
          <div class="col-md-7" style="margin-left:-60px">
                {{ Form::hidden('emp_id', $empdownload->id) }}
                <a href= "../<?= $empdownload->path ?>" download><?= $empdownload->file_name?><br> (click here to download)</a><br><br>
                 {{ Form::submit('View', array('class' => 'btn btn-info')) }}          
         
           </div>
               {{ Form::close() }}

         </div>
      </div>
      @endforeach
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