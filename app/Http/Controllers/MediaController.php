<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use DataTables;


class MediaController extends Controller
{
    
    public function index(Request $request)
    {
   
        $medias = Media::latest()->get();
        
        if ($request->ajax()) {
            $data = Media::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editMedia">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteMedia">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('media',compact('medias'));
    }
     
    
    public function store(Request $request)
    {
        if ($request->hasFile('video')) {

            $file = $request->file('video');
            $path = 'videos/';
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = 'webm';
            $fileNameToStore = preg_replace('/\s+/', '_', 'Recording' . '_' . time() . '.' . $extension);

            \Storage::disk('public')->putFileAs($path, $file, $fileNameToStore);

            $media = Media::create(['video' => $fileNameToStore, 'title' => $fileNameToStore, 'name' => $fileNameToStore]);

            return  response()->json(['success' => ($media) ? 1 : 0, 'message' => ($media) ? 'Video uploaded successfully.' : "Some thing went wrong. Try again !."]);
        }

       
        Media::updateOrCreate(['id' => $request->media_id],['title' => $request->title, 'name' => $request->name, 'video' => $request->video]);      
   
        return response()->json(['success'=>'Media saved successfully.']);
    }
    
    // public function update(Request $request, $id)
    // {

    //     $media = Media::find($id);
    //     $media->name=$request->name;
    //     $media->title=$request->title;
    //     $media->video=$request->video;
    //     $media->save();
    //     return response()->json($media);

    // }

    public function edit($id)
    {
        $media = Media::find($id);
        return response()->json($media);
    }
  
    
    public function destroy($id)
    {
        Media::find($id)->delete();
     
        return response()->json(['success'=>'Media deleted successfully.']);
    }
}
