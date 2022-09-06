<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
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
            'user_id' => 'nullable|string|max:10',
            'location' => 'nullable|string|max:10',
            'name' => 'nullable|string|max:10',
            'last_name' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:10',
            'company_name' => 'nullable|string|max:10',

        ]);
        $id = $request->has("id")?$request->id:null;
        $user_id = $request->has('user_id')?$request->user_id:null;
        $location = $request->has('location')?$request->location:null;
        $name = $request->has('name')?$request->name:null;
        $last_name = $request->has('last_name')?$request->last_name:null;
        $phone = $request->has('phone')?$request->phone:null;
        $address = $request->has('address')?$request->address:null;
        $company_name = $request->has('company_name')?$request->company_name:null;
        $sellers = Seller::when($id, function ($query, $id){
            $query->where('id', $id);})
        ->when($user_id, function ($query, $user_id){
            $query->where('user_id', $user_id);})
        ->when($location, function ($query, $location){
                $query->whereHas('location', function ($query2) use ($location){
                    $query2->where('name', 'like', '%' . $location . '%');});})
        ->when($name, function ($query, $name){
            $query->where('name', 'like', '%' . $name . '%');})
        ->when($last_name, function ($query, $last_name){
            $query->where('last_name', 'like', '%' . $last_name . '%');})
        ->when($phone, function ($query, $phone){
            $query->where('phone', 'like', '%' . $phone . '%');})
        ->when($address, function ($query, $address){
            $query->where('address', 'like', '%' . $address . '%');})
        ->when($company_name, function ($query, $company_name){
            $query->where('company_name', 'like', '%' . $company_name . '%');})
        ->orderBy('id')
        ->with('location')
        ->paginate(50)
        ->withQueryString();;
        return view('admin.sellers.index', compact([
            'id',
            'user_id',
            'location',
            'name',
            'last_name',
            'phone',
            'address',
            'company_name',
            'sellers',]));
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
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        //
    }
}
