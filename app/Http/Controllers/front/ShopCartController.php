<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\OutfitItem;
use App\Models\Seller;
use App\Models\ShopCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShopCartController extends Controller
{
    public function index()
    {
       Inertia::render('front/basket/index');
    }

    public function addItem( $id,Request $request)
    {
        $request->validate([
            'quantity'=>'numeric|required',
            'seller'=>'numeric|required',
        ]);
        $seller = Seller::findOrFail($request->seller);
        $outfitItem = OutfitItem::findOrFail($id);
        $checkShopCart = ShopCart::where('user_id', Auth::user()->id)->where('seller_id', $seller->id)->first();
        // $check = $outfitItem->shopCarts->where('user_id', Auth::user()->id)->where('seller_id', $seller->id);
        if ($checkShopCart) {
            $itemInShopCart = $checkShopCart->outfitItems->where('id', $outfitItem->id);
            if ($itemInShopCart->count()>0) {
                $itemInShopCart->first()->pivot->increment('quantity', $request->quantity);
            }else {
                $checkShopCart->outfitItems()->attach($outfitItem->id, ['quantity'=> $request->quantity]);
            }
        }else{
            $shopcart = ShopCart::create(['user_id'=>Auth::user()->id, 'seller_id'=>$seller->id]);
            $shopcart->outfitItems()->attach($outfitItem->id, ['quantity' => $request->quantity]);
        }
        return redirect()->back()->with(['success'=>'ustunlikli goshuldy']);
    }
}
