<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/fdpf.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/datepicker3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.multiselect.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.multiselect.filter.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery-ui.css') }}" />
     <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-clockpicker.min.css') }}"/>
     <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery-clockpicker.min.css') }}"/>
     <script src="{{ URL::asset('js/jquery.js') }}"></script>
        <script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
     <script src="{{ URL::asset('js/jquery.multiselect.js') }}"></script>
      <script src="{{ URL::asset('js/jquery.multiselect.filter.js') }}"></script>
      <script src="{{ URL::asset('js/bootstrap-clockpicker.min.js') }}"></script>
      <script src="{{ URL::asset('js/jquery-clockpicker.min.js') }}"></script>
      <script src="{{ URL::asset('js/jqueryformultifield.js') }}"></script>
      <script src="{{ URL::asset('js/filtertable.js') }}"></script>

  </head>
  <body>
    <div class = "container">
      @include("includes.header")
       @yield("content")
    </div>
      
    <div class = "footer">
      @include("includes.footer")
    </div>
      
  </body>
</html>