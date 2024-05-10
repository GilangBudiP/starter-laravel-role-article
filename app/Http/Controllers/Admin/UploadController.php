<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request, $model)
    {
        $path = match ($model) {
            'cover' => 'tmp/cover',
            'gallery' => 'tmp/gallery',
            'logo_white' => 'tmp/logo',
            'logo_black' => 'tmp/logo',
            'discover' => 'tmp/discover',
            default => 'tmp/images'
        };
        $multiple = $request->query('multiple');
        if ($multiple && $request->allFiles()) {
            $file = $request->allFiles()[$model][0];
        } elseif (!$multiple || $multiple === false) {
            $file = $request->file($model);
        } else {
            return response()->json([
                'message' => 'File not uploaded'
            ], 500);
        }
        $filename = $file->getClientOriginalName();
        $folder = uniqid() . '-' . now()->timestamp;
        $file->storeAs($path . '/' . $folder, $filename);

        TemporaryFile::create([
            'folder' => $folder,
            'filename' => $filename
        ]);

        return $folder;
    }

    public function restore(Request $request, $model, $folder)
    {
        $path = TemporaryFile::where('folder', $folder)->firstOrFail();
        $url = Storage::url('tmp/' . $model . '/' . $path->folder . '/' . $path->filename);
        return $url;
    }

    public function destroyTmp(Request $request, $model, $folder)
    {
        $tmpFile = TemporaryFile::where('folder', $folder)->firstOrFail();
        $tmpFile->delete();
        Storage::deleteDirectory('tmp/' . $model . '/' . $folder);
        return response()->json([
            'message' => 'File deleted'
        ], 200);
    }

    public function destroy(Request $request, $model)
    {
        $folder = $request->getContent();
        if (!$folder) {
            return response()->json([
                'message' => 'File not found'
            ], 404);
        }
        $file = TemporaryFile::where('folder', $folder)->first();
        if ($file) {
            $file->delete();
            if (Storage::exists('tmp/' . $model . '/' . $folder)) {
                Storage::deleteDirectory('tmp/' . $model . '/' . $folder);
                return response()->json([
                    'message' => 'File deleted'
                ], 200);
            } else {
                return 'file tidak ketemu';
            }
        } else {
            return response()->json([
                'message' => 'File not found'
            ], 404);
        }
    }
}
