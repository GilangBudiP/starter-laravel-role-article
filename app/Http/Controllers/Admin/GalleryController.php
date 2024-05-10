<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('galleries.read');
        $galleries = Gallery::latest()->paginate(6);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('galleries.create');
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('galleries.create');

        foreach ($request->gallery as $gall) {
            $temporaryFile = TemporaryFile::where('folder', $gall)->first();
            if ($temporaryFile) {
                $gallery = Gallery::create(['name' => $temporaryFile->filename]);
                $gallery->addMedia(storage_path('app/tmp/gallery/' . $gall . '/' . $temporaryFile->filename))
                    ->toMediaCollection('gallery');
                rmdir(storage_path('app/tmp/gallery/' . $gall));
                $temporaryFile->delete();
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Image uploaded successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        $this->authorize('galleries.update');
        $galleries = Gallery::all();
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update($gallery_id, UpdateGalleryRequest $request)
    {
        $this->authorize('galleries.update');
        $gallery = Gallery::where('id', $gallery_id)->first();
        $gallery->update($request->only('name', 'status'));
        foreach ($request->gallery as $gall) {
            $temporaryFile = TemporaryFile::where('folder', $gall)->first();

            if ($temporaryFile) {
                $gallery->addMedia(storage_path('app/tmp/gallery/' . $gall . '/' . $temporaryFile->filename))
                    ->toMediaCollection('gallery');
                rmdir(storage_path('app/tmp/gallery/' . $gall));
                $temporaryFile->delete();
            }
        }

        $gallery->save();
        return redirect()->route('admin.galleries.index')->with('success', 'Image Edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $this->authorize('galleries.delete');
        $gallery->delete();
        return redirect()->back()->with('success', 'Data Deleted Successfully');
    }

    public function destroyImage(Gallery $gallery, $image)
    {
        $gallery->deleteMedia($image);
        return response()->json(['message' => 'Image Deleted Successfully']);
    }
}
