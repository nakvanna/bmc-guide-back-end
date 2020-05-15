<?php

namespace App\Http\Controllers;

use App\Models\BlogGallery;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BlogGalleryController extends Controller
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
    public function store(Request $request)
    {
        $galleries = $request->file('galleries');
        $input = $request->all();
        $request -> validate([
            'galleries'   => 'required',
            'blog_id' => 'required',
        ]);
        
        foreach ($galleries as $file) {
            $img = Image::make($file)->encode('png', 100);
            $name = uniqid().'-'.time() . '.png';
            Storage::disk('public')->put('images/'.$name, $img);
            
            $store = new BlogGallery();
            $store->blog_id = $input['blog_id'];
            $store->gallery = url(Storage::url('images/'.$name));
            $store->save();
        }
        return Blog::where('id', $input['blog_id'])->with('blog_gallery')->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogGallery  $blogGallery
     * @return \Illuminate\Http\Response
     */
    public function show(BlogGallery $blogGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogGallery  $blogGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogGallery $blogGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogGallery  $blogGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogGallery $blogGallery)
    {
        //
    }

    public function updateCustom(Request $request, $id){
        $galleries = $request->file('galleries');
        $input = $request->all();
        $request -> validate([
            'galleries'   => 'required',
            'blog_id' => 'required',
        ]);
        
        foreach($galleries as $file){
            $img = Image::make($file)->encode('png', 100);
            $name = uniqid().'-'.time() . '.png';
            Storage::disk('public')->put('images/'.$name, $img);

            $update = new BlogGallery();
            $update->blog_id = $input['blog_id'];
            $update->galleries = url(Storage::url('images/'.$name));
            $update->save();
        }
        return BlogGallery::where('id', $input['blog_id'])->with('blog_gallery')->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogGallery  $blogGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $path = BlogGallery::where('id', $id)->get('gallery')[0]['gallery'];
        $p_path = explode('/', $path);
        $name = $p_path[3];
        BlogGallery::findOrFail($id)->delete();
        Storage::disk('public')->delete("images/".$name);
    }
}
