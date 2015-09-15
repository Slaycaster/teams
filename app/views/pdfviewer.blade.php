@extends("layout")
@section("content")

<head>
    <title><?= $download->file_name?> | Time and Electronic Attendance Monitoring System</title>
</head>

            
                <iframe src="../<?= $download->path ?>" title="your_title" align="top" height="100%" width="100%" frameborder="0" scrolling="auto" target="Message">
                    <!-- Alternate content for non supporting browsers -->
                    <p align="center">Please click <a href="window.location.href='your_script.php'">here </a> to continue.</p>
                </iframe>

				
				   
				<hr>
			

@stop