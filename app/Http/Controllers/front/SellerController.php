<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\OutfitSeller;
use App\Models\Seller;
use App\Models\Location;
use App\Models\Order;
use App\Models\Outfit;
use App\Models\OutfitItem;
use App\Models\User;
use App\Models\Value;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SellerController extends Controller
{
    //seller
    public function my_outfits()
    {
        $seller_id = Auth::user()->seller->id ?: abort('403');
        $outfits = Outfit::where('seller_id', $seller_id)
            ->with('seller.location', 'values.option', 'tags')->get();

        return view('front.seller.my_outfits', compact("outfits"));
    }

    public function create()
    {
        $locations = Location::get();
        return Inertia::render('front/seller/register', ['locations' => $locations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "location_id" => ['required', 'numeric'],
            'seller_name' => ['required', 'string', 'max:255'],
            'seller_last_name' => ['required', 'string', 'max:255'],
            'seller_phone' => ['required', 'numeric'],
            'shop_address' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
        ]);

        $seller = Seller::create(
            [
                'user_id' => Auth::id(),
                "location_id" => $request->location_id,
                'seller_name' => $request->seller_name,
                'seller_last_name' => $request->seller_last_name,
                'seller_phone' => $request->seller_phone,
                'shop_address' => $request->shop_address,
                'company_name' => $request->company_name,
            ]
        );
        $user = User::findOrfail(Auth::id());
        $user->role = 'seller';
        $user->save();


        return redirect()->route('home');
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'categories'=>[Rule::requiredIf($request->has("validate")), 'array',],
        ]);
        $categories = Category::whereNull('category_id')->with('children')->get();
        $chosenCategories = collect($request->categories)->flatten()->filter(function ($value) {
            return $value == true;
        })->count()>0?collect($request->categories)->flatten()->filter(function ($value) {
            return $value == true;
        }):null;
        $options = $chosenCategories?Category::whereIn('id', $chosenCategories)->with('options.values')->get()->pluck('options')->unique('id'):null;
        return Inertia::render('front/seller/CreateProduct', [
            'categories'=>$categories,
            'options'=>$options
    ]);
    }

    function sendToLastStep(Request $request){

        $request->validate([
            'image'=>['required', 'image', 'mimes:jpg,png'],
            'name'=>['required', 'string'],
            'description'=>['required', 'string','max:2550'],
            'categories'=>[ 'array'],
            'values'=>['required', 'array'],
            'values.*'=>['required', 'numeric'],
            'variations'=>['required', 'array'],
            'variations.*.variation'=>['required', 'string'],
            'variations.*.options'=>['required', 'array'],
            'variations.*.options.*'=>['required'],
        ]);

        //Create product
        $outfit = new Outfit();
        $outfit->name = $request->name;
        $outfit->description = $request->description;
        $outfit->seller_id = Auth::user()->seller->id;
        $outfit->slug = Str::slug($request->name);
        $outfit->confirmed = 0;
        if ($request->has('image')) {
            $newImage = $request->file('image');
            $newImageName = Str::random(10) . '-' . $outfit->id . '.' . $newImage->getClientOriginalExtension();
            Storage::putFileAs('public/oufits/', $newImage, $newImageName);
               $newImage->storeAs('public/outfits/', $newImageName);
    
            $outfit->image = $newImageName;
        }
        $outfit->save();

        //Attach product to categories
        $categories = collect($request->categories)->flatten()->filter(function ($value) {
            return $value == true;
        });
        $categories = Category::whereIn('id', $categories)->get();
        $outfit->categories()->attach($categories->pluck('id'));

        //Attach values to product
        $values = Value::whereIn('id', $request->values)->get();
        $outfit->values()->attach($values->pluck('id'));

        //Create variations and options and also attach them to product
        // {'variation':'variation name', 'options':['list','of','option names']}
        foreach ($request->variations as $value) {
            $variation = Variation::create(['name'=>$value['variation'], 'outfit_id'=>$outfit->id]);
            foreach ($value['options'] as $option) {
                $option = VariationOption::create(['option'=>$option, 'variation_id'=>$variation->id]);
            }
        }

        //send it to seller.add.item GET route so that it can be also usefull in the future when seller wants to add item to existing product and also it helps in refresh coz direct redirection to add item page is not saving model binding in the route so it would crash on refresh coz it will keep POST link;
        return redirect()->route('seller.add.item', $outfit->id);

    }

    //addItem function for future use and refresh availability
    public function addItem(Outfit $outfit)
    {

        if (! Gate::allows('add-item', $outfit)) {
            abort(403);
        }

        return Inertia::render('front/seller/AddItemToProduct', [
            'product'=>$outfit->load('variations.variation_options'),
    ]);
    }

    public function storeItem(Outfit $outfit, Request $request)
    {
        if (! Gate::allows('add-item', $outfit)) {
            abort(403);
        }
        $request->validate([
            'items'=>['required', 'array'],
            'items.*.options'=>['required', 'array'],
            'items.*.stock'=>['required', 'numeric'],
            'items.*.price'=>['required', 'numeric'],
        ]);

        foreach ($request->items as $item) {
            $outfititem = new OutfitItem();
            $outfititem->outfit_id = $outfit->id;
            $outfititem->stock = $item['stock'];
            $outfititem->price = $item['price'];
            $outfititem->save();
            $outfititem->variation_options()->attach($item['options']);
        }

        return redirect()->route('home');
    }

    public function showDashboard()
    {
        $orders = Order::where('seller_id', Auth::user()->seller->id)->with('outfitItem.outfit', 'seller')->get();
        $paid = $orders->where('order_status', 'paid');
        $accepted = $orders->where('order_status', 'accepted');
        $sent = $orders->where('order_status', 'sent');
        $received = $orders->where('order_status', 'received');
        return Inertia::render('front/seller/SellerDashboard', [
            'paid'=>$paid,
            'accepted'=>$accepted,
            'sent'=>$sent,
            'received'=>$received,
        ]);
    }


    public function acceptOrder(Order $order)
    {
        if (! Gate::allows('accept-order', $order)) {
            abort(403);
        }
        $order->update(['order_status'=>'accepted']);

        return redirect()->back();
    }
}
