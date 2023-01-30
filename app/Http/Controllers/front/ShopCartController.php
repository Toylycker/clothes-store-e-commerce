<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $shopcarts = ShopCart::where('user_id', Auth::user()->id)->with('seller', 'outfitItems.outfit', 'outfitItems.variation_options')->get();
       return Inertia::render('front/basket/index', ['shopcarts'=>$shopcarts]);
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

    public function updateQuantity($itemId, $quantity)
    {
        $shopcart = OutfitItem::findOrFail($itemId)->shopCarts->where('user_id', Auth::user()->id)->first();
        $shopcart->outfitItems()->updateExistingPivot($itemId, [
            'quantity' => $quantity
        ]);

        return redirect()->back();
    }

    public function setOrder(Request $request)
    {
       $request->validate([
        'orders'=>'required|array',
        'orders.*'=>'required|numeric',
       ]);

       foreach ($request->orders as $itemId) {
        $outfitItem = Outfititem::findOrFail($itemId);
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->outfit_item_id = $outfitItem->id;
        $order->seller_id = $outfitItem->outfit->seller->id;
        $order->from_location = Auth::user()->address;
        $order->to_location = $outfitItem->outfit->seller->shop_address;
        $order->order_num = $outfitItem->id . '-' . rand(111, 999);
        $order->receiver_phone = Auth::user()->phone;
        $order->sender_phone = $outfitItem->outfit->seller->seller_phone;
        $order->price = $outfitItem->price;
        $order->quantity = $outfitItem->shopcarts->where('user_id', Auth::user()->id)->first()->pivot->quantity;
        $order->order_status = 'paid';
        $order->save();
        $shopcart = $outfitItem->shopcarts->where('user_id', Auth::user()->id)->first();
        $shopcart->outfitItems()->detach($outfitItem->id);
        if ($shopcart->outfitItems->count()>0) {
        }else{
            $shopcart->delete();
        }
    }
        return redirect()->back();
    }

    public function destroy($itemId)
    {
        $shopcart = OutfitItem::findOrFail($itemId)->shopCarts->where('user_id', Auth::user()->id)->first();
        $shopcart->outfitItems()->detach($itemId);
        if ($shopcart->outfitItems->count()>0) {
            return redirect()->back();
        }else{
            $shopcart->delete();
            return redirect()->back();
        }

    }
}
