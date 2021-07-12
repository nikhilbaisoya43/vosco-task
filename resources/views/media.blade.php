<!DOCTYPE html>
<html>
<head>
    <title>VOSCO Task by Yadavendra Yadav</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container">
    <h1>Coding Assessment</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="newWebcamRecording">New Webcam Recording</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Video Title</th>
                <th>Video Name</th>
                <th>Video Preview</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="mediaForm" name="mediaForm" class="form-horizontal">
                   <input type="hidden" name="media_id" id="media_id">
                    
                            <input type="hidden" class="form-control" id="video" name="video" placeholder="Enter Title" value="" maxlength="50" required="">
                        
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="webcamModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">New Webcam Recording</h4>
            </div>
            <div class="modal-body">
                
<div class="row">
	<div class="col-md-6">
		<h2>Preview</h2>
		<video id="preview" width="160" height="120" autoplay muted></video><br/><br/>
		<div class="btn-group">
			<div id="startButton" class="btn btn-success"> Start Recording </div>
			<div id="stopButton" class="btn btn-danger"  style="display:none;"> Stop </div>
		</div>
	</div>
	<div class="col-md-6" id="recorded"  style="display:none">
		<h2>Recording</h2>
		<video id="recording" width="160" height="120" controls></video><br/><br/>
		<a id="downloadButton" class="btn btn-primary">Save</a>
		<a id="downloadLocalButton" class="btn btn-primary">Download</a>
	</div>
</div>
<script>
	navigator.mediaDevices.getUserMedia({
		video: true,
		audio: false
	})
</script>
<script>
    
    let preview = document.getElementById("preview");
    let recording = document.getElementById("recording");
    let startButton = document.getElementById("startButton");
    let stopButton = document.getElementById("stopButton");
    let downloadButton = document.getElementById("downloadButton");
    let logElement = document.getElementById("log");
    let recorded = document.getElementById("recorded");
    let downloadLocalButton = document.getElementById("downloadLocalButton");

    let recordingTimeMS = 5000; //video limit 5 sec
    var localstream;

    window.log = function (msg) {
    //logElement.innerHTML += msg + "\n";
    console.log(msg);
    }

    window.wait = function (delayInMS) {
    return new Promise(resolve => setTimeout(resolve, delayInMS));
    }

    window.startRecording = function (stream, lengthInMS) {
        let recorder = new MediaRecorder(stream);
        let data = [];

        recorder.ondataavailable = event => data.push(event.data);
        recorder.start();
        log(recorder.state + " for " + (lengthInMS / 1000) + " seconds...");

        let stopped = new Promise((resolve, reject) => {
            recorder.onstop = resolve;
            recorder.onerror = event => reject(event.name);
        });

        let recorded = wait(lengthInMS).then(
            () => recorder.state == "recording" && recorder.stop()
        );

        return Promise.all([
            stopped,
            recorded
            ])
        .then(() => data);
    }

    window.stop = function (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    var formData = new FormData();
    if (startButton) {
        startButton.addEventListener("click", function () {
            startButton.innerHTML = "recording for 5 secs...";
            recorded.style.display = "none";
            stopButton.style.display = "inline-block";
            downloadButton.innerHTML = "rendering..";
            navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            }).then(stream => {
                preview.srcObject = stream;
                localstream = stream;
                //downloadButton.href = stream;
                preview.captureStream = preview.captureStream || preview.mozCaptureStream;
                return new Promise(resolve => preview.onplaying = resolve);
            }).then(() => startRecording(preview.captureStream(), recordingTimeMS))
            .then(recordedChunks => {
                let recordedBlob = new Blob(recordedChunks, {
                type: "video/webm"
                });
                recording.src = URL.createObjectURL(recordedBlob);

                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append('video', recordedBlob);

                downloadLocalButton.href = recording.src;
                downloadLocalButton.download = "RecordedVideo.webm";
                log("Successfully recorded " + recordedBlob.size + " bytes of " +
                recordedBlob.type + " media.");
                startButton.innerHTML = "Start";
                stopButton.style.display = "none";
                recorded.style.display = "block";
                downloadButton.innerHTML = "Save";
                localstream.getTracks()[0].stop();
            })
            .catch(log);
        }, false);
    }
    
    if (downloadButton) {
        downloadButton.addEventListener("click", function () {
            $.ajax({
            url: "{{route('medias.store')}}",
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            // success: function (res) {
            //     if(res.success){
            //         location.reload();
            //     }
            // }
            success: function (data) {
              $('#webcamModel').modal('hide');
              var table = $('.data-table').DataTable();
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#downloadButton').html('Save Changes');
          }
            });
        }, false);
    }
    
    if (stopButton) {
        stopButton.addEventListener("click", function () {
            stop(preview.srcObject);
            startButton.innerHTML = "Start";
            stopButton.style.display = "none";
            recorded.style.display = "block";
            downloadButton.innerHTML = "Save";
            localstream.getTracks()[0].stop();
        }, false);
    }

    
    

</script>
            </div>
        </div>
    </div>
</div>
    

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
<script type="text/javascript">
  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('medias.index') }}",
        columns: [
            {data: 'id', number: 'media_id'},
            {data: 'title', name: 'title'},
            {data: 'name', name: 'name'},
            {data: 'video', name: 'video', 
                render: function(data, type, full, meta){
                    return "<iframe width='auto' src={{ URL::to('/') }}/storage/videos/" + data + " frameborder='0' allow='accelerometer; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                },
                orderable: false, searchable: false
            },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#newWebcamRecording').click(function () {
        $('#saveBtn').val("create-media");
        $('#media_id').val('');
        $('#modelHeading').html("Create New Webcam Recording");
        $('#webcamModel').modal('show');
    });
    $('body').on('click', '.editMedia', function () {
      var media_id = $(this).data('id');
      $.get("{{ route('medias.index') }}" +'/' + media_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Media");
          $('#saveBtn').val("edit-media");
          $('#ajaxModel').modal('show');
          $('#media_id').val(data.id);
          $('#title').val(data.title);
          $('#name').val(data.name);
          $('#video').val(data.video);
      })
   });
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#mediaForm').serialize(),
          url: "{{ route('medias.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#mediaForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteMedia', function () {
     
        var media_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('medias.store') }}"+'/'+media_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>
</body>
</html>