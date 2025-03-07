<!DOCTYPE html>
<html lang="en">
<head>
  <title>Preview and Remove image before upload JQuery and Codeigniter - Elevenstech Web Tutorials</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="icon" type="image/png" href="https://elevenstechwebtutorials.com/module/logo/baba1.png" />
  
</head>
<body>
  
<div class="container">
  <div class="row">
    <div class="col-sm-2"></div>
    <form action="<?php echo base_url(); ?>preview_upload/save" method="post" enctype="multipart/form-data"  id="upload_image">
        
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                <h3 align="center" style="line-height: 40px;">Preview and Remove image before upload JQuery and Codeigniter<br>
                Elevenstech Web Tutorials</h3>
                <?php if($success = $this->session->flashdata('success')){ ?>
                     <div class="alert alert-success" role="alert">
                          <?= $success; ?>
                     </div>
                <?php } ?>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-sm-10">
                <label class="select-image">
                     <span class="upload-text">Upload New</span>
                     <input type="file" class="image-file" multiple="" required="" accept="image/png, image/jpeg">
                </label>
            </div>
            <div class="col-sm-2">
                <button type="submit" name="submit" class="btn btn-primary upload-image">Upload</button>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <span id="selected-images"></span>
        </div>
        
    </div>
    
    
    </form>
    <div class="col-sm-2"></div>
  </div>
</div>
<script type="text/javascript">
      $(document).ready(function() {
          
        if (window.File && window.FileList && window.FileReader) 
        {
          $(".image-file").on("change", function(e) 
          {
            var file = e.target.files,
            imagefiles = $(".image-file")[0].files;
            var i = 0;
            $.each(imagefiles, function(index, value){
              var f = file[i];
              var fileReader = new FileReader();
              fileReader.onload = (function(e) {

                $('<div class="pip col-sm-3 col-4 boxDiv" align="center" style="margin-bottom: 20px;">' +
                  '<img style="width: 120px; height: 100px;" src="' + e.target.result + '" class="prescriptions">'+
                  '<p style="word-break: break-all;">' + value.name + '</p>'+
                  '<p class="cross-image remove">Remove</p>'+
                  '<input type="hidden" name="image[]" value="' + e.target.result + '">' +
                  '<input type="hidden" name="imageName[]" value="' + value.name + '">' +
                  '</div>').insertAfter("#selected-images");
                  $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                  });
              });
              fileReader.readAsDataURL(f);
              i++;
            });
          });
        } else {
          alert("Your browser doesn't support to File API")
        }
      });
</script>

<script>
    $('document').ready(function(e){
      $('.upload-image').click(function(e){
         var imageDiv = $(".boxDiv").length; 
         if(imageDiv == ''){
           alert('Please upload image'); // Check here image selected or not
           return false;
         }
         else if(imageDiv > 5){
           alert('You can upload only 5 images'); //You can select only 5 images at a time to upload
           return false;
         }
         else if(imageDiv != '' && imageDiv < 6){ // image should not be blank or not greater than 5
            $("#upload_image").submit();
         }
      });
    });
</script>
</body>
</html>