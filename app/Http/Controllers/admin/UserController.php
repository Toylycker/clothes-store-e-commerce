<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
            'username' => 'nullable|string|max:10',
            'role' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:10',
            'also_seller' => 'nullable|boolean',
            'seller_id' => 'nullable|string|max:10',
        ]);
        $id = $request->has("id")?$request->id:null;
        $username = $request->has("username")?$request->username:null;
        $role = $request->has("role")?$request->role:null;
        $also_seller = $request->also_seller?:null;
        $phone = $request->phone?:null;
        $seller_id = $request->seller_id?:null;
        $users = User::when($id, function ($query, $id){
            $query->where('id', $id);
        })->when($username, function ($query, $username){
            $query->where('username', 'like', '%' . $username . '%');
        })->when($role, function ($query, $role){
            $query->where('role', 'like', '%' . $role . '%');
        })->when($phone, function ($query, $phone){
            $query->where('phone', 'like', '%' . $phone . '%');
        })->when(isset($also_seller), function ($query, $also_seller){
            $query->whereHas('seller');
        })->when($seller_id, function ($query, $seller_id){
            $query->whereHas('seller', function ($query) use ($seller_id){
                $query->where("id", $seller_id);
            });
        })
        ->orderBy('id')
        ->with('seller')
        ->paginate(50)
        ->withQueryString();;
        return view('admin.users.index', compact([
            'id',
            'username',
            'role',
            'also_seller',
            'seller_id',
            'phone',
            'users',]));
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
