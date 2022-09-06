<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OutfitSeller;
use App\Models\Seller;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    //seller
    public function my_outfits()
    {
        $seller_id = Auth::user()->seller->id?:abort('403');
        $outfitsellers = Outfitseller::where('seller_id', $seller_id)
        ->with('seller.location','outfit.values.option', 'outfit.tags')->get();

        return view('front.seller.my_outfits', compact("outfitsellers"));
    }

    public function create()
    {
        $locations = Location::get(); 
        return view('front.seller.register', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => ['required', 'int', 'max:10',],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'integer'],
            'address' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
        ]);

        $seller = Seller::create([
            'user_id' => Auth::user()->id,
            'location_id' => $request->location_id,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
        ]);

        return redirect()->route('outfit.create');
    }
}