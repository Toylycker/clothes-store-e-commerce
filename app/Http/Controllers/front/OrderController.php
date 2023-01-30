<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\outfit;
use App\Models\Location;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Orderoutfit;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GotOrderNotification;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->with('outfitItem.outfit', 'seller')->get();
        $paid = $orders->where('order_status', 'paid');
        $accepted = $orders->where('order_status', 'accepted');
        $sent = $orders->where('order_status', 'sent');
        $received = $orders->where('order_status', 'received');
        return Inertia::render('front/orders/index', [
            'paid'=>$paid,
            'accepted'=>$accepted,
            'sent'=>$sent,
            'received'=>$received,
        ]);
    }
}
