<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\OutfitSeller;
use App\Models\Location;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderOutfitSeller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GotOrderNotification;
use Illuminate\Support\Collection;



class OrderController extends Controller
{
    public function add_to_basket($id) // here in request should be slug key for slug and order key for defining whether to add into basket or delete
    {

        $outfitseller = Outfitseller::where('id', $id)
            ->firstOrFail();
        $basket = [];

        if (Cookie::has('store_outfits') && Cookie::has('outfit_quantity')) {
            $cookies = explode(",", Cookie::get('store_outfits'));
            $quantity = explode(",", Cookie::get('outfit_quantity'));
            if (in_array($outfitseller->id, $cookies)) {
                $index = array_search($outfitseller->id, $cookies);
                unset($cookies[$index]);
                unset($quantity[$index]);
            } else {
                $cookies[] = $outfitseller->id;
                $quantity[] = 1;
            }
            Cookie::queue('store_outfits', implode(",", $cookies), 60 * 24);
            Cookie::queue('outfit_quantity', implode(",", $quantity), 60 * 24);
            // $basket = explode(",", Cookie::get('store_comps'));
        } else {
            Cookie::queue('store_outfits', $outfitseller->id, 60 * 24);
            Cookie::queue('outfit_quantity', 1, 60 * 24);
            // $basket = explode(",", Cookie::get('store_comps'));
        }

        return redirect()->back();
    }





    public function basket_()
    {
        $cookies = explode(",", Cookie::get('store_outfits'));
        $locations = Location::get();
        $outfitsellers = Outfitseller::WhereIn("id", $cookies)->with('outfit.values', 'outfit.tags', 'outfit', 'seller')
        ->paginate(20, [
            '*'], 'page')
            ->withQueryString();



        return view("front.app.basket", [
            'outfitsellers'=>$outfitsellers,
            'basket'=>$cookies,
            'locations'=> $locations,
            'total_price' => 0
            ]);
    }


    public function set_order(Request $request){
        $request->validate([
            "location_id"=> 'required',
            "address"=> 'required',
            "phone"=> 'required',
            'note'=> 'required',
        ]);

        // Auth::user()->notify(new GotOrderNotification());

        $cookies = explode(",", Cookie::get('store_outfits'));

        //Create order
        $order = new Order;
        $order->location_id = $request->location_id;
        $order->user_id = AUTH::user()->id;
        $order->order_num = AUTH::user()->id . rand( 100, 9999999);
        $order->phone = $request->phone;
        $order->note = $request->note;
        $order->save();

        $outfitsellers = Outfitseller::whereIn('id', $cookies)->with('outfit.age', 'seller')->get();
        foreach ($outfitsellers as $outfitseller) {
            $order_detail = new OrderOutfitSeller;
            $order_detail->order_id = $order->id;
            $order_detail->outfit_seller_id = $outfitseller->id;
            $order_detail->age_id = $outfitseller->outfit->age->id;
            $order_detail->quantity = 1;
            $order_detail->discount = 0;
            $order_detail->save();
            $seller = $outfitseller->seller->id;
            $user = User::whereHas('seller', function ($query) use ($seller){
                $query->where('id', $seller);
            })->first();

            $user->notify(new GotOrderNotification());
        }

        Cookie::queue('store_outfits', "", 60 * 24);
        Cookie::queue('outfit_quantity', "", 60 * 24);
        
        return redirect()->route('outfits.home');
    }

    public function show_orders(){
        $orders = Order::where('user_id', Auth::user()->id)
        ->with('orderoutfitsellers.outfitseller.outfit.tags',
        'orderoutfitsellers.outfitseller.seller'
        )->orderBy('id', 'desc')
        ->paginate(10, ['*'], 'page')
        ->withQueryString();

        return view('front.orders.my_orders', compact('orders'));
    }

    public function show_sales(){
        $orders = OrderOutfitSeller::whereHas('outfitseller', function ($query){
            return $query->where('seller_id', Auth::user()->seller->id);
        })
        ->with('order', 'outfitseller.outfit.tags', 'outfitseller.seller')
        ->orderBy('id', 'desc')->get()->groupBy('order.order_num');

        $orders = $orders->paginate(5);


        Auth::user()->unreadNotifications()->delete();
        // Auth::user()->unreadNotifications->markAsRead();
        // Auth::user()->readNotifications()->delete();

        return view('front.orders.my_sales', compact('orders'));
    }


    public function fetch(){

        $result = Location::all();
        return response()->json([
            'result'=>$result]);
    }
}
