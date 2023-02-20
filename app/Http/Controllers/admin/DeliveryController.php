<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class DeliveryController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/delivery/index');
    }

    public function storeDeliveryman(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'deliveryman';
        $user->save();

        event(new Registered($user));

        return $user;

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }
}
