@extends("layout")
@section("content")
        @foreach ($downloads as $download)
            <div class = "col-md-4">
                <iframe src="../<?= $download->path ?>" title="your_title" align="top" height="450" width="100%" frameborder="0" scrolling="auto" target="Message">
                    <!-- Alternate content for non supporting browsers -->
                    <p align="center">Please click <a href="window.location.href='your_script.php'">here </a> to continue.</p>
                </iframe>

				<img src="{{ URL::asset('img/Request.png') }}">
				    <a href= "../<?= $download->path ?>" download><?= $download->file_name?></a>
				<hr>
			</div>
        @endforeach	
</div>
@stop