@extends("layout_employee")
@section("content")
<head>
    <title>Downloadable Forms | Time and Electronic Attendance Monitoring System</title>
</head>
        <div class="container">
          <br><br><br>
        <h1 styles="margin-left:100px">All Forms</h1><hr>

        @foreach ($downloads as $download)
            <div class="col-md-5" style="margin-bottom:5px">
        <div class="col-md-12 greytile" style="padding:5px">
          <div class="col-md-5" >
               <img style = "height:80px; width:80px;" src="{{ URL::asset('img/Download.png') }}">
          </div>
          {{ Form::open(array('url' => 'employee/pdfviewer', 'method' => 'post', 'autocomplete' => 'off')) }}
          <div class="col-md-7" style="margin-left:-60px">
                {{ Form::hidden('download', $download->id) }}
                <a href= "../<?= $download->path ?>" download><?= $download->file_name?><br> (click here to download)</a><br><br>
                {{ Form::submit('View', array('class' => 'btn btn-info')) }} 
               
           </div>

         </div>
      </div>
        {{ Form::close() }}
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