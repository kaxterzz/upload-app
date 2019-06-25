<?php

namespace App\Http\Controllers;
use File;
use Image;
use App\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $uid = auth()->user()->id;
        $files = Content::where('user_id', $uid)
                ->get();
        $output = "";
        if($files->count()){
            foreach ($files as $key => $data) {
                $output.='<tr>'.

                '<td>'.$data->original_file_name.'</td>'.
    
                '<td>'.'<a href="storage/'.$data->file_url.'" target="_blank">Download</a>'.'</td>'.
    
                '</tr>';
            }
            return response()->json(['alert'=>'success','res'=>$output]);
        }else{
            return response()->json(['alert'=>'empty']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
          'file' => 'required'
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $content = new Content;
        
        $file_name = $request->file('file')->getClientOriginalName();

        $path = $request->file('file')->store('uploads');

        $content->user_id = auth()->user()->id;
        $content->original_file_name = $file_name;
        $content->file_url = $path;
        $content->save();

        return redirect()->back()->with('success', ['Data Saved']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
