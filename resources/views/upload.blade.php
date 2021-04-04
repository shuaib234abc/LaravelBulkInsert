<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bulk Insert Demonstration</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" />

        <!-- references: https://laracasts.com/discuss/channels/laravel/how-to-fix-csrf-token-mismatch-for-patch-ajax-request-2nd-time -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>
    <body>

      <div style="width:60%;padding:3%;margin:0px auto;margin-top:5%;border:1px solid #ccc;box-shadow:10px 20px 20px #888888">

        <!-- ref: https://getbootstrap.com/docs/5.0/components/card/ -->
        <div class="card">
          <div class="card-body">
                <h5 class="card-title">Bulk Data Upload</h5>
                <p class="card-text" style="padding-top:3%">
                    <ul>
                      <li>Please upload a very large dataset.</li>
                      <li>A sample dataset can be found below.</li>
                      <li>You can upload the sample file or another file of same format.</li>
                      <li>This dataset has been taken from <a target="_blank" href="https://github.com/duyet/bruteforce-database">https://github.com/duyet/bruteforce-database<a/></li>
                      <li>Dataset author: Van-Duyet Le, dataset license: <a target="_blank" href="https://github.com/duyet/bruteforce-database/blob/master/LICENSE">MIT</a></li>

                    </ul>
                </p>
                <a download href="{{ URL::asset('custom/sample-dataset/facebook-firstnames.txt')}}" class="btn btn-primary">Download sample data</a>

                <hr />

                <!-- UI/UX design ref: CoreUI v3.2.0 (Bootstrap 4 Admin template, https://coreui.io) -->
                <form
                  id="this-form"
                  name="this-form"
                  method="POST" enctype="multipart/form-data"
                  >
                          @csrf

                          <div class="row">
                							<div class="col-xs-12 col-sm-12 col-md-12">
                								<div class="form-group">
                									<strong>Upload data</strong>
                                  <input class="form-control" id='file' name="file" type='file' multiple/>
                								</div>
                							</div>
                          </div>

                          <br />

                          <div class="row">
                            <div class="col-xs-4">
                              <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          </div>
                </form>

          </div>
        </div>

      </div>

    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous"></script>
    <script type="text/javascript">

      $(document).ready(function() {

        var formHandler = document.getElementById('this-form');
        var fileInputElem = document.getElementById('file');
        var fileToUpload = null;

        //references: https://laracasts.com/discuss/channels/laravel/how-to-fix-csrf-token-mismatch-for-patch-ajax-request-2nd-time
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fileInputElem.addEventListener('change', function (evnt) {
            for (var i = 0; i < fileInputElem.files.length; i++) {
              fileToUpload = (fileInputElem.files[i]);
            }
        });

        formHandler.addEventListener('submit', function (event) {
          event.preventDefault();

          var formData = new FormData();
          formData.set('file', fileToUpload);

          jQuery.ajax({
            type: "POST",
            url: window.location.href,
            data: formData,
            processData: false,
            contentType: false,
            success: function(result){
              toastr.success('Data has been uploaded successfully.', 'Info')
            }
          });
        });

      });

    </script>
</html>
