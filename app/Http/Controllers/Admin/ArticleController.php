<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('articles.read');
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('articles.create');
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $this->authorize('articles.create');
        $article = Article::create($request->only('title', 'category_id', 'body', 'status') + ['user_id' => Auth::user()->id]);
        $article->seo()->update([
            'description' => $request->description,
        ]);
        $this->storeBody($article);
        $temporaryFile = TemporaryFile::where('folder', $request->cover)->first();

        if ($temporaryFile) {
            $article->addMedia(storage_path('app/tmp/cover/' . $request->cover . '/' . $temporaryFile->filename))
                ->toMediaCollection('cover');
            rmdir(storage_path('app/tmp/cover/' . $request->cover));
            $temporaryFile->delete();
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('articles.read');
        $articles = Article::all();
        $categories = Category::all();
        return view('admin.articles.show', compact('article', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('articles.update');
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('articles.update');
        $article->update($request->only('title', 'category_id', 'body', 'status'));
        $temporaryFile = TemporaryFile::where('folder', $request->cover)->first();
        $this->storeBody($article);
        if ($temporaryFile) {
            $article->addMedia(storage_path('app/tmp/cover/' . $request->cover . '/' . $temporaryFile->filename))
                ->toMediaCollection('cover');
            rmdir(storage_path('app/tmp/cover/' . $request->cover));
            $temporaryFile->delete();
        }

        $article->seo->update([
            'description' => $request->description,
        ]);

        $article->save();
        return redirect()->route('admin.articles.index')->with('success', 'Article Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('articles.delete');
        $article->delete();
        return redirect()->back()->with('success', 'Data Deleted Successfully');
    }

    public function getSrcAttribute($value): array
    {
        $srcArray = array();
        preg_match_all('/<img src="([^"]*)"/', $value, $srcArray);
        return $srcArray[1];
    }

    public function storeImageBody(Article $article, $path)
    {
        $tmpFile = TemporaryFile::where('folder', $path['folder'])->first();
        if ($tmpFile) {
            $storedimage = $article->addMedia(public_path($path['disk'] . '/' . $tmpFile['folder'] . '/' . $tmpFile['filename']))
                ->toMediaCollection('body');
            $tmpFile->delete();
            return $storedimage->getUrl();
        }
        return $path['folder'];
    }

    public function replaceSrcAttribute($oldSrc, $newSrc, $text)
    {
        if ($newSrc) {
            $text = str_replace($oldSrc, $newSrc, $text);
            return $text;
        }
    }

    public function storeBody(Article $article)
    {
        $srcArray = $this->getSrcAttribute($article->body);
        $articleBody = $article->body;
        foreach ($srcArray as $key => $url) {
            $newUrl = $this->storeImageBody($article, $this->getImagePath($url));
            $articleBody = $this->replaceSrcAttribute($url, $newUrl, $articleBody);
        }
        $article->body = $articleBody;
        $article->save();
    }

    public function getImagePath($url)
    {
        $path = explode('/', parse_url($url, PHP_URL_PATH));
        if($path[2] != 'temporary') {
            return [
                'folder' => $url
            ];
        }
        return [
            'disk' => $path[1] . '/' . $path[2],
            'folder' => $path[3],
            'filename' => $path[4]
        ];
    }

    public function destroyImage(Article $article, $image)
    {
        $article->deleteMedia($image);
        return response()->json(['message', 'Image Deleted Successfully']);
    }
}
