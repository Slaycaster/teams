@extends("layout_employee")
@section("content")

<head>
    <title>Forms| Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:30px">
<br><br><br>
    <h1>Your File</h1>

</div>
<div class="col-md-6">
@foreach($empdownloads as $empdownload)
    <div class="col-md-12" style="padding:5px">
      <div class="col-md-4" >
      </div>
     <br>
      <div class="col-md-8" style="margin-left:0px">
       <p style="color:white; font-size:20px"> <strong>{{$empdownload->file_name}}</strong></p><br>
       <a href="empdownloads" class="btn btn-warning">Go Back</a>
       </div>
     </div>
      </div>
      <div class="col-md-6"></div>

<br><br>
  <div class="col-md-12">
     <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
   
    <center>   <iframe src="../<?= $empdownload->path ?>" title="downloads"  height= "800" width="600"  frameborder="0" margin-left= "100px" target="Message"></iframe><center>
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

