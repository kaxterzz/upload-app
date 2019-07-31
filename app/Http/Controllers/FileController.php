<?php

namespace App\Http\Controllers;
use File;
use Image;
use App\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $user = auth()->user();
        $files = "";
        if(auth()->user()->hasRole('user')){
            $files = Content::all();
        }else if(auth()->user()->hasRole('customer')){
            $files = Content::where('user_id', 17)
                ->get();
        }else{
            $files = Content::where('user_id', $uid)
                ->get();
        }
        
        $output = "";
        $remove_links = "";
        if($files->count()){
            foreach ($files as $key => $data) {
                if($user->hasAnyRole(['super admin', 'admin'])){
                    $remove_links = '<td>'.'<a href="javascript:void(0);" id="removeLink" class="removeLink">Remove</a>'.'</td>';
                }

                $output.='<tr>'.

                '<td>'.$data->original_file_name.'</td>'.
    
                //'<td>'.'<a href="download/'.$data->original_file_name.'" target="_blank">Download</a>'.'</td>'.
                //'<td>'.'<a href="{{ asset(storage/'.$data->file_url.') }}" target="_blank">Download</a>'.'</td>'.
                
                '<td class="text-md-right">'.'<a href="javascript:void(0);" id="downLink" class="downLink">Download</a>'.'</td>'.
                //'<td>'.'<button type="button" class="btn btn-primary btn-sm">Download</button>'.'</td>'.
                $remove_links.
                
                
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

        $extension = $request->file('file')->getClientOriginalExtension();
        $original_file_name = $request->file('file')->getClientOriginalName();

        $filename = $original_file_name.'.'.$extension; 

        $path = Storage::putFileAs(
            'uploads', $request->file('file'), $original_file_name
        );

        //$path = Storage::disk('public')->putFileAs('uploads', $request->file('file'), $original_file_name);
        
        

        //$path = $request->file('file')->store('uploads');

        $content->user_id = auth()->user()->id;
        $content->original_file_name = $original_file_name;
        $content->file_url = $path;
        $content->source = "local";
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
    public function destroy(Content $content,$file_name)
    {
        try {
            $uid = auth()->user()->id;
            $rf = Content::where('user_id',$uid)->where('original_file_name',$file_name)->delete();
            $df = unlink(public_path('uploads/'.$file_name));

            if($rf && $df){
                return response()->json(['alert'=>'success']);
            }
        } catch (\Throwable $th) {
            return response()->json(['msg'=>$th->getMessage()]);
        }
    }
}
