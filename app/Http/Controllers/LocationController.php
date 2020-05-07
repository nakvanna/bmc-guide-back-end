<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location = Location::with('gallery')->get();
        return $location;
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
        $thumbnail = $request->file('thumbnail');
        $input = $request->all();
        $request->validate ([
            'user_id'        => 'required',
            'name'           => 'required',
            'category'       => 'required',
            'sub_category'   => 'required',
            'location_coord' => 'required',
            'thumbnail'      => 'required',
            'website'        => 'required',
            'tel'            => 'required',
            'email'          => 'required',
            'can_do'         => 'required',
            'about'          => 'required',
        ]);
        $img = Image::make($thumbnail)->encode('png',100);
        $name = uniqid().'-'.time() . '.png';
        Storage::disk('public')->put('images/'.$name, $img);

        $store = new Location();
        $store-> user_id = $input['user_id'];
        $store-> name = $input['name'];
        $store-> category = $input['category'];
        $store-> sub_category = $input['sub_category'];
        $store-> location_coord = $input['location_coord'];
        $store-> thumbnail = Storage::url('images/'.$name);
        $store-> website = $input['website'];
        $store-> tel = $input['tel'];
        $store-> email = $input['email'];
        $store-> can_do = $input['can_do'];
        $store-> about = $input['about'];
        $store->save();

        return $store;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $request->validate([
            'name'           => 'required',
            'category'       => 'required',
            'sub_category'   => 'required',
            'location_coord' => 'required',
            // 'thumbnail'      => 'required',
            'website'        => 'required',
            'tel'            => 'required',
            'email'          => 'required',
            'can_do'         => 'required',
            'about'          => 'required',
        ]);

        $update = Location::findOrFail($id);
        $update-> name = $input['name'];
        $update-> category = $input['category'];
        $update-> sub_category = $input['sub_category'];
        $update-> location_coord = $input['location_coord'];
        // $update-> thumbnail = Storage::url('images/'.$name);
        $update-> website = $input['website'];
        $update-> tel = $input['tel'];
        $update-> email = $input['email'];
        $update-> can_do = $input['can_do'];
        $update-> about = $input['about'];

        $update->save();
        return Location::find($update->id);
    }


    public function updateCustom(Request $request, $id)
    {
        $thumbnail = $request->file('thumbnail');
        $input = $request->all();
        $request->validate([
            'user_id'        => 'required',
            'name'           => 'required',
            'category'       => 'required',
            'sub_category'   => 'required',
            'location_coord' => 'required',
            'website'        => 'required',
            'tel'            => 'required',
            'email'          => 'required',
            'can_do'         => 'required',
            'about'          => 'required',
        ]);
        $update = Location::findOrFail($id);

        if(isset($input['thumbnail'])){
            $img = Image::make($thumbnail)->encode('png',90);
            $name = uniqid().'-'.time() . '.png';
            Storage::disk('public')->put('images/'.$name, $img);
            $update-> thumbnail = Storage::url('images/'.$name);
        }
        
        $update-> user_id = $input['user_id'];
        $update-> name = $input['name'];
        $update-> category = $input['category'];
        $update-> sub_category = $input['sub_category'];
        $update-> location_coord = $input['location_coord'];
        $update-> website = $input['website'];
        $update-> tel = $input['tel'];
        $update-> email = $input['email'];
        $update-> can_do = $input['can_do'];
        $update-> about = $input['about'];

        $update->save();
        return Location::where('id', $update->id)->with('gallery')->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::findOrFail($id)->delete();
    }
}
