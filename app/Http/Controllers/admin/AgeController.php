<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Age;
use Illuminate\Http\Request;

class AgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer|min:1',
            'name' => 'nullable|string|max:10',
        ]);
        $id = $request->has("id")?$request->id:null;
        $name = $request->has("name")?$request->name:null;
        $ages = Age::when($id, function ($query, $id){
            $query->where('id', $id);
        })->when($name, function ($query, $name){
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->orderBy('id')
        ->paginate(50)
        ->withQueryString();;
        return view('admin.ages.index', compact(['ages', 'id', 'name']));
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
     * @param  \App\Models\Age  $age
     * @return \Illuminate\Http\Response
     */
    public function show(Age $age)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Age  $age
     * @return \Illuminate\Http\Response
     */
    public function edit(Age $age)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Age  $age
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Age $age)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Age  $age
     * @return \Illuminate\Http\Response
     */
    public function destroy(Age $age)
    {
        //
    }
}
