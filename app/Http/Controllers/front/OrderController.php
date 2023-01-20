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



class OrderController extends Controller
{
}
