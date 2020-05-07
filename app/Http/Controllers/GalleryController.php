<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Location;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
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
            'location_id' => 'required',
        ]);
        
        foreach ($galleries as $file) {
            $img = Image::make($file)->encode('png', 100);
            $name = uniqid().'-'.time() . '.png';
            Storage::disk('public')->put('images/'.$name, $img);
            
            $store = new Gallery();
            $store->location_id = $input['location_id'];
            $store->galleries = Storage::url('images/'.$name);
            $store->save();
        }
        // return $store;
        return Location::where('id', $input['location_id'])->with('gallery')->first();
    }

    public function updateCustom(Request $request, $id){
        $galleries = $request->file('galleries');
        $input = $request->all();
        $request -> validate([
            'galleries'   => 'required',
            'location_id' => 'required',
        ]);
        
        foreach($galleries as $file){
            $img = Image::make($file)->encode('png', 100);
            $name = uniqid().'-'.time() . '.png';
            Storage::disk('public')->put('images/'.$name, $img);

            $update = new Gallery();
            $update->location_id = $input['location_id'];
            $update->galleries = Storage::url('images/'.$name);
            $update->save();
        }
        return Location::where('id', $input['location_id'])->with('gallery')->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $path = Gallery::where('id', $id)->get('galleries')[0]['galleries'];
        $p_path = explode('/', $path);
        $name = $p_path[3];
        Gallery::findOrFail($id)->delete();
        Storage::disk('public')->delete("images/".$name);
    }
}
