<?php

namespace App\Http\Controllers;
use App\DownloadInfo;
use Illuminate\Http\Request;

class FileOperationsController extends Controller
{
    protected function save_download_info(Request $request){
        try {
            $download_info = new DownloadInfo;
            $download_info->user_id = auth()->user()->id;
            $download_info->file_name = $request->fileName;

            $download_info->save();

            return response()->json(['alert'=>'success']);
        } catch (\Throwable $th) {
            return response()->json(['msg'=>$th->getMessage()]);
        }
        
    }   
}
