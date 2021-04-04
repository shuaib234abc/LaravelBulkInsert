<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Person;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    /**
     * Store a newly added resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNew(Request $request)
    {
        /*
        References:
        1.https://stackoverflow.com/questions/32718870/how-to-get-all-input-of-post-in-laravel
        2.https://www.tutsmake.com/laravel-8-crud-example-tutorial/
        3.https://laracasts.com/discuss/channels/laravel/base64-to-upload-image
        */

        $output = "";
        $paramName = "file";
        if($request->file($paramName) != null){
            $directory = ('\\public\\uploads\\');
            $curDate = date('Y-m-d__H_i_s');     //ref: https://www.php.net/manual/en/function.date.php, https://stackoverflow.com/questions/1135573/how-do-i-create-a-variable-in-php-of-todays-date-of-mm-dd-yyyy-format/1135593
            $fileNameToStore = $curDate . ".txt";
            $request->file($paramName)->storeAs($directory, $fileNameToStore);        //ref: https://laracasts.com/discuss/channels/laravel/how-direct-upload-file-in-storage-folder

            //read file line by line and store to DB
            //ref: https://stackoverflow.com/questions/53008105/laravel-5-6-how-to-read-text-file-line-by-line
            $content = fopen(Storage::path($directory.$fileNameToStore),'r');
            while(!feof($content)){
                $line = fgets($content);

                /* save //////////////// /////////////// /////////////////////// /////////////////////// */
                //ref: https://www.tutsmake.com/laravel-8-crud-example-tutorial/
                $newItem = new Person;
        				$newItem->name = $line;
                $newItem->save();
                /* ///////////////////// /////////////// /////////////////////// /////////////////////// */

            }
            fclose($content);

        }

        $output = new \stdClass();
        $output->statusText = "Data has been uploaded successfully";

        return response()->json($output);
    }
}
