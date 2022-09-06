<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request;
        $request->validate([
            'id' => 'nullable|integer|min:1',
            'name' => 'nullable|string|max:10',
            'name_en' => 'nullable|string|max:10',
        ]);
        $id = $request->has("id")?$request->id:null;
        $name = $request->has("name")?$request->name:null;
        $name_en = $request->has("name_en")?$request->name_en:null;
        $locations = Location::when($id, function ($query, $id){
            $query->where('id', $id);
        })->when($name, function ($query, $name){
            $query->where('name', 'like', '%' . $name . '%');
        })->when($name_en, function ($query, $name_en){
            $query->where('name_en', 'like', '%' . $name_en . '%');
        })
        ->orderBy('id')
        ->paginate(50)
        ->withQueryString();;
        return view('admin.locations.index', compact(['locations', 'id', 'name', 'name_en']));
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
        //
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
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
