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


        $data = $request->bigstring;
        $data = json_decode($data);
        $final_data = array();

        foreach($data as $d){
          $obj = array();
          $obj['name'] = $d;
          array_push($final_data, $obj);
        }

        //ref: https://laravel.com/docs/8.x/collections#method-chunk
        $collection = collect($final_data);
        $chunks = $collection->chunk(50000);
        foreach($chunks as $c){
          Person::insert($c->toArray());            //ref: https://stackoverflow.com/questions/12702812/bulk-insertion-in-laravel-using-eloquent-orm
        }

        $output = new \stdClass();
        $output->statusText = "Data has been uploaded successfully";
        $output->insertCount = count($final_data);

        return response()->json($output);
    }
}
