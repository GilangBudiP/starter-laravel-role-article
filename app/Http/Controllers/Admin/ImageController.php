<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImageController extends Controller
{
    public function check()
    {
        return 'this is for checking functional of route and controller';
    }

    public function store(Request $request)
    {
        $file = $request->file('upload');
        $temporaryFile = TemporaryFile::create([
            'folder' => uniqid() . '-' . now()->timestamp,
            'filename' => $file->getClientOriginalName(),
        ]);
        $file->move(public_path('img/temporary/') . $temporaryFile->folder, $temporaryFile->filename);

        return response()->json([
            'url' => asset('img/temporary/' . $temporaryFile->folder . '/' . $temporaryFile->filename),
        ]);
    }

    public function destroy($id, $name)
    {
        $media = Media::where('id', $id)->where('file_name', $name)->first();
        if ($media) {
            $media->delete();
            return response()->json([
                'message' => 'File Deleted'
            ], 200);
        } else {
            return response()->json([
                'message' => 'File Not Found'
            ], 400);
        }
    }
}
