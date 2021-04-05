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
                                <button id="btn_submit" type="submit" class="btn btn-success">Submit</button>
                                <div id="divMessage"></div>
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
        var arrayOfArrays = [];
        var chunk = 500000;
        var totalToInsert = 0;
        var totalInsertedUptoNow = 0;
        var timeStarted = null;
        var timeEnded = null;

        var showMessage = function(msg, firstTime){
          var h = "";
          if(!firstTime) h = $("#divMessage").html();
          h += msg;
          h += "<br />";
          $("#divMessage").html(h);
          toastr.success(msg, "Info");
        }

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

          $("#btn_submit").css("display","none");
          showMessage("Data is being inserted. Please wait.", true);

          event.preventDefault();

          var i,j,temparray;

          //ref: https://stackoverflow.com/questions/23331546/how-to-use-javascript-to-read-local-text-file-and-read-line-by-line
          var reader = new FileReader();
          reader.onload = function(progressEvent){

            var lines = this.result.split('\n');
            totalToInsert = lines.length;

            //ref: https://stackoverflow.com/questions/8495687/split-array-into-chunks
            for (i=0,j=lines.length; i<j; i+=chunk) {
                temparray = lines.slice(i,i+chunk);
                arrayOfArrays.push(temparray);
            }

            //the following code has been taken from https://www.webniraj.com/2018/10/08/making-ajax-calls-sequentially-using-jquery/
            ////////////////////// /////////////////////////////////// //////////////////////////////////////
            var ajax_request = function(item) {
                var deferred = $.Deferred();
                var formData = new FormData();

                //console.log("Initiating AJAX call");
                //console.log(item);

                formData.set("bigstring", JSON.stringify(item));

                $.ajax({
                  type: "POST",
                  url: window.location.href,
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    //console.log("Response from ajax call: " + data);
                    totalInsertedUptoNow += data.insertCount;
                    var message = totalInsertedUptoNow + " out of " + totalToInsert + " data added successfully. " + (((totalInsertedUptoNow / totalToInsert) * 100).toFixed(2)) + " percent completed.";
                    showMessage(message, false);
                    deferred.resolve(data);  // mark the ajax call as completed
                  },
                  error: function(error) {
                    deferred.reject(error); // mark the ajax call as failed
                  }
                });

                return deferred.promise();
            };

            var looper = $.Deferred().resolve();
            timeStarted = new Date();

            $.when.apply($, $.map(arrayOfArrays, function(item, i) {      // go through each item and call the ajax function
              looper = looper.then(function() {
                return ajax_request(item);    // trigger ajax call with item data
              });
              return looper;
            })).then(function() {
              showMessage('All data has been inserted successfully.', false);       // run this after all ajax calls have completed
              timeEnded = new Date();
              var timeDiff = ((timeEnded - timeStarted) / (1000 * 60)).toFixed(2);
              showMessage("Time taken : " + timeDiff + " minutes.", false);
            });
            //////////////////////// ///////////////////////////////// //////////////////////////////////////
          };      //end of reader.onload = function(progressEvent){ }
          reader.readAsText(fileToUpload);

        });     // end of formHandler.addEventListener('submit', function (event) { }

      });

    </script>
</html>
