<?php

namespace App\Http\Controllers\API;
use File;
use Image;
use App\Content;
use App\User;
use App\OnimtaImage;
use App\OnimtaCustomers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        try {
            //header('Content-Type: bitmap; charset=utf-8');
            // $m = Input::get('image');
            // echo $m;
                //echo $_POST;
            //$request = Request::instance();
            // $content = $request->getContent();
            // $b = $content["image"];
            // echo $b;

            // $r = file_get_contents('php://input');
            // echo $r['image'];
            // $c = $_POST["file"];
            // echo $c;

            // $content = $request->image;
            // echo $content;
            //var_dump($content);


            //dd($content);
            //dd($content['file']);

            //  $img = $request->input('image');

            //  echo $img;
            $username = $request->Username;
            $img = $request->image;
            echo $img;
            $image_decode = base64_decode($img);
            // $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
    
            // $f = finfo_open();
            // $mime_type = finfo_buffer($f, $image_decode, FILEINFO_MIME_TYPE);
            // // $imageName = "image-".time().'.'.str_replace("image/","",$mime_type);
            // $imageName = "image-".time().'.png';

            // $tmpFilePath=sys_get_temp_dir().'/'.uniqid();
            // file_put_contents($tmpFilePath, $image_decode);
            // $tmpFile=new File($tmpFilePath);
            // File::move($tmpFilePath, storage_path("app/public/api-images/$imageName"));
            $imageName = "image-".time().'.png'; 
            $path = url('/')."/uploads/api-images/".$imageName;
            
            // $image = str_replace('data:image/png;base64,', '', $file);
            // $image = str_replace(' ', '+', $image);
            
            $binary=base64_decode($img);
            echo $binary;
            header('Content-Type: bitmap; charset=utf-8');
            $file = fopen(storage_path("app/public/api-images/".$imageName),'w');
            fwrite($file, $binary);
            fclose($file);



            //$max_id = User::max('id');
            $image = new OnimtaImage;
            $customer_id = OnimtaCustomers::max('idCustomer');
            $image->Customer_idCustomer = $customer_id;
            $image->Url = $path;
            $image->Date_time = date('Y-m-d H:i:s');
            $image->save();
    
            if($image){
                return response()->json(['status'=>true]);
            }else{
                return response()->json(['status'=>false]);
            }
        } catch (\Throwable $th) {
            return response()->json(['err'=>$th->getMessage()]);
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
