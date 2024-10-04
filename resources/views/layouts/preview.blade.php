



<style type="text/css">
    img {
    display: block;
    max-width: 100%;
    }
    .preview {
    overflow: hidden;
    width: 160px; 
    height: 160px;
    margin: 10px;
    border: 1px solid red;
    }
    .modal-md{
    max-width: 600px !important;
    }
    </style>
    
    
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Crop Blog Image</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <div class="img-container">
    <div class="row">
    <div class="col-md-8">
    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
    </div>
    <div class="col-md-4">
    <div class="preview"></div>
    </div>
    </div>
    </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
    </div>
    </div>
    </div>
    </div>
    
    <script>
    var $modal = $('#modal');
    
    var image = document.getElementById('image');
    var cropper;
    $("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
    image.src = url;
    $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
    file = files[0];
    if (URL) {
    done(URL.createObjectURL(file));
    } else if (FileReader) {
    reader = new FileReader();
    reader.onload = function (e) {
    done(reader.result);
    };
    reader.readAsDataURL(file);
    }
    }
    });
    $modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
    aspectRatio: 1,
    viewMode: 3,
    preview: '.preview'
    });
    }).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
    });
    $("#crop").click(function(){
       
        var imghol = document.getElementById("imgHolder");
        imghol.style.display = "none";
    canvas = cropper.getCroppedCanvas({
    width: 160,
    height: 160,
    });
    canvas.toBlob(function(blob) {
    url = URL.createObjectURL(blob);
    var reader = new FileReader();
    reader.readAsDataURL(blob); 
    reader.onloadend = function() {
    var base64data = reader.result; 
    
    alert(base64data);
    src="data:image/png;base64, {{ $base64data?? "" }}"
    imghol.src = base64data;
    imghol.style.display = "block";
    alert("tapedza");
    
    $.ajax({
    type: "POST",
    dataType: "json",
    url: "crop-image-upload",
    data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
    
    
    
    success: function(data){
    console.log(data);
    $modal.modal('hide');
    alert("Crop image successfully uploaded");
    }
    });
    }
    });
    })
    </script>