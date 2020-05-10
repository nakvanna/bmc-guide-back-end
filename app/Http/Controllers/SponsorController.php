<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sponsor::all();
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
        $image = $request->file('image');
        $input = $request->all();
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $img = Image::make($image)->encode('png',100);
        $name = uniqid().'-'.time() . '.png';
        Storage::disk('public')->put('images/'.$name, $img);

        $store = new Sponsor();
        $store-> image = Storage::url('images/'.$name);
        $store-> price = $input['price'];
        $store-> name = $input['name'];
        $store-> user_id = $input['user_id'];
        $store-> description = $input['description'];
        $store-> save();

        return $store;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsor $sponsor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sponsor::findOrFail($id)->delete();
    }

    public function updateCustom(Request $request, $id){
        $image = $request->file('image');
        $input = $request->all();
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $update = Sponsor::findOrFail($id);

        if(isset($input['image'])){
            $img = Image::make($image)->encode('png',100);
            $name = uniqid().'-'.time() . '.png';
            Storage::disk('public')->put('images/'.$name, $img);
            $update-> image = Storage::url('images/'.$name);
        }

        $update-> price = $input['price'];
        $update-> name = $input['name'];
        $update-> user_id = $input['user_id'];
        $update-> description = $input['description'];
        $update-> save();

        return Sponsor::where('id', $update->id)->first();;
    }
}
