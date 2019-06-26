<?php

namespace App\Http\Controllers\API;
use File;
use Image;
use App\Content;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $file = $request->file;
        $image_decode = base64_decode($file);
        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));

        $f = finfo_open();
        $mime_type = finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE);
        $imageName = "image-".time().'.'.str_replace("image/","",$mime_type);
        $tmpFilePath=sys_get_temp_dir().'/'.uniqid();
        file_put_contents($tmpFilePath, $image_data);
        $tmpFile=new File($tmpFilePath);
        File::move($tmpFilePath, storage_path("app/uploads/api-images/$imageName"));
        $path = "uploads/api-images/".$imageName;

        $max_id = User::max('id');
        $content = new Content;
        $content->user_id = $max_id;
        $content->original_file_name = $imageName;
        $content->file_url = $path;
        $content->source = "api";
        $content->save();

        if($content){
            return response()->json('true');
        }else{
            return response()->json('false');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
