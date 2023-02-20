<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Outfit;
use App\Models\Option;
use App\Models\Tag;
use Illuminate\Support\Str;
use App\Models\Seller;
use App\Models\OutfitSeller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OutfitController extends Controller
{
    public function admin_index(Request $request){
        $request->validate([
            'id' => 'nullable|integer|min:1',
            'name' => 'nullable|string|max:10',
            'name_en' => 'nullable|string|max:10',
            'value' => 'nullable|string|max:10',
            'slug' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:10',
            'description_en' => 'nullable|string|max:10',
            'viewed' => 'nullable|boolean',
            'recommended' => 'nullable|boolean',
            'liked' => 'nullable|boolean',
            'updated_at' => 'nullable|string|max:10',
            'created_at' => 'nullable|string|max:10',
        ]);
        $id = $request->id ?: null;
        $name = $request->name ?: null;
        $name_en = $request->name_en ?: null;
        $slug = $request->slug ?: null;
        $description = $request->description ?: null;
        $description_en = $request->description_en ?: null;
        $viewed = $request->viewed ?: null;
        $recommended = $request->recommended ?: null;
        $liked = $request->liked ?: null;
        $updatedAt = $request->updated_at ?: null;
        $createdAt = $request->created_at ?: null;
        $value = $request->value ?: null;

        $outfits = Outfit::when($id, function ($query, $id) {
                return $query->where('id', 'like', '%' . $id . '%');
            })
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($name_en, function ($query, $name_en) {
                return $query->where('name_en', 'like', '%' . $name_en . '%');
            })
            ->when($value, function ($query, $value) {
                return $query->where(function ($query1) use ($value) {
                        $query1->whereHas('values', function ($query2) use ($value) {
                            $query2->where('name',  'like', '%' . $value . '%');
                        });
                });
            })
            ->when($slug, function ($query, $slug) {
                return $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($description, function ($query, $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->when($description_en, function ($query, $description_en) {
                return $query->where('description_en', 'like', '%' . $description_en . '%');
            })
            ->when($viewed, function ($query, $viewed) {
                return $query->where('viewed', $viewed);
            })
            ->when($recommended, function ($query, $recommended) {
                return $query->where('recommended', $recommended);
            })
            ->when($liked, function ($query, $liked) {
                return $query->where('liked', $liked);
            })
            ->when($updatedAt, function ($query, $updatedAt) {
                return $query->where('updated_at', 'like', '%' . $updatedAt . '%');
            })
            ->when($createdAt, function ($query, $createdAt) {
                return $query->where('created_at', 'like', '%' . $createdAt . '%');
            })
            ->orderBy('updated_at')
            ->orderBy('id')
            ->with(['tags', 'values.option', 'outfitsellers.seller',])
            ->paginate(50)
            ->withQueryString();


        return Inertia::render('admin.outfits.index', compact([
            'id',
            'name',
            'name_en',
            'slug',
            'description',
            'description_en',
            'viewed',
            'recommended',
            'liked',
            'updatedAt',
            'createdAt',
            'outfits',
            'value'
        ]));
    }

    public function create()
    {
        $sellers = Seller::get();
        $outfit = Outfit::with(['seller'])
            ->get();
        $outfitseller = Outfitseller::with(['outfit'])
            ->get();
        $tags = Tag::orderBy('id')
            ->get();
         $options = Option::with(['values'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return Inertia::render('admin.outfits.create', [
            'outfit' => $outfit,
            'tags' => $tags,
            'options' => $options,
            'sellers' => $sellers,
        ]);
    }


    public function store(Request $request)
    {   
        $request->validate([
            'description' => 'nullable|string|max:2550',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount_percent' => 'required|integer|min:0',
            'discount_datetime_start' => 'required|date',
            'discount_datetime_end' => 'required|date',
            'credit' => 'nullable|boolean',
            'recommended' => 'nullable|boolean',
            'values_id' => 'required|array',
            'values_id.*' => 'required|integer|min:1|distinct',
            'image' => 'nullable|image|mimes:jpg,png|dimensions:min_width=500,min_height=500|max:1024',
        ]);
    $seller = Seller::findOrFail($request->seller_id);
    $name = $request->name;
    $name_en = $request->name_en;

    // outfit
    $outfit = new Outfit;
    $outfitseller = new Outfitseller;
    $outfit->name = $name;
    $outfit->name_en = $name_en;
    $outfit->slug = Str::slug($name) . '-' . $outfit->id;
    // $outfit->description = $request->description ?: null;
    // $outfit->description_en = $request->description_en ?: null;
    $outfit->recommended = $request->recommended ?: 0;
    $outfit->save();
    $outfitseller->outfit_id = $outfit->id;
    $outfitseller->seller_id = $seller->id;
    $outfitseller->description = $request->description ?: null;
    $outfitseller->description_en = $request->description_en ?: null;
    $outfitseller->price = $request->price;
    $outfitseller->stock = $request->stock;
    $outfitseller->discount_percent = $request->discount_percent;
    $outfitseller->discount_datetime_start = Carbon::parse($request->discount_datetime_start)->toDateTimeString();
    $outfitseller->discount_datetime_end = Carbon::parse($request->discount_datetime_end)->toDateTimeString();
    $outfitseller->credit = $request->credit ?: 0;
    $outfit->recommended = $request->recommended ?: 0;
    $outfitseller->save();

    $outfit->values()->sync($request->values_id);
    $outfit->tags()->sync($request->tags);

    // image
    if ($request->has('image')) {
        if ($outfit->image) {
            Storage::delete($outfit->image);
        }
        $newImage = $request->file('image');
        $newImageName = Str::random(10) . '-' . $outfit->id . '.' . $newImage->getClientOriginalExtension();
        Storage::putFileAs('public/oufits/', $newImage, $newImageName);
           $newImage->storeAs('public/outfits/', $newImageName);

        $outfit->image = $newImageName;
        $outfit->update();
    }

    $success = trans('app.update-response', ['name' => $outfit->name]);

        $success = trans('app.store-response', ['name' => $outfit->name]);
        return redirect()->route('admin.outfits.show', [$outfit->id, $seller->id])
            ->with([
                'success' => $success,
            ]);
    }


    public function edit($id, $seller_id)
    {
        if (Auth::user()->seller != null and Auth::user()->seller->id == $seller_id or Auth::user()->role =="admin"){
            // pass;
        }else{
            abort(403);
        }
         $sellers = Seller::get();
        $outfit = Outfit::where('id', $id)
            ->with(['outfitsellers.seller'])
            ->firstOrFail();
        $outfitseller = Outfitseller::where('outfit_id', $id)
            ->where('seller_id', $seller_id)
            ->with(['outfit'])
            ->firstOrFail();
        $tags = Tag::orderBy('id')
            ->get();
        $options = Option::with(['values'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return Inertia::render('admin.outfits.edit', [
            'outfit' => $outfit,
            'tags' => $tags,
            'options' => $options,
            'outfitseller' => $outfitseller,
            'sellers' => $sellers,
        ]);
    }


    public function update(Request $request, $id)
    {   
        $outfit = Outfit::where('id', $id)
            ->firstOrFail();
        $request->validate([
            'seller_id' => 'required|integer|min:1',
            'name' => 'nullable|string|max:2550',
            'name_en' => 'nullable|string|max:2550',
            'description' => 'nullable|string|max:2550',
            'description_en' => 'nullable|string|max:2550',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sold' => 'required|integer|min:0',
            'discount_percent' => 'required|integer|min:0',
            'credit' => 'nullable|boolean',
            'recommended' => 'nullable|boolean',
            'values_id' => 'required|array',
            'values_id.*' => 'required|integer|min:1|distinct',
            'tags.*' => 'required|integer|min:1|distinct',
            'image' => 'nullable|image|mimes:jpg,png|dimensions:min_width=500,min_height=500|max:1024',
        ]);

        // name
        // $outfitseller = Outfitseller::where('outfit_id', $id)->where("seller_id", $request->seller_id)
        //     ->firstOrFail();
        $outfitseller = Outfitseller::firstOrCreate(['outfit_id'=>$id, 'seller_id'=>$request->seller_id]);
        $seller = Seller::findOrFail($request->seller_id);
        $name = $request->name;
        $name_en = $request->name_en;

        // outfit. actually seller should not change name and description ofm outfit itself as other seller also having it with same id. seller should only change price and discount.
        $outfitseller->seller_id = $seller->id;
        $outfit->name = $name;
        $outfit->name_en = $name_en;
        $outfit->slug = Str::slug($name) . '-' . $outfit->id;
        $outfitseller->description = $request->description ?: null;
        $outfitseller->description_en = $request->description_en ?: null;
        $outfitseller->price = $request->price;
        $outfitseller->stock = $request->stock;
        $outfitseller->discount_percent = $request->discount_percent;
        $outfitseller->credit = $request->credit ?: 0;
        $outfit->recommended = $request->recommended ?: 0;
        $outfit->update();
        $outfitseller->update();

        $outfit->values()->sync($request->values_id);
        $outfit->tags()->sync($request->tags);

        // image
        if ($request->has('image')) {
            if ($outfit->image) {
                Storage::delete($outfit->image);
            }
            $newImage = $request->file('image');
            $newImageName = Str::random(10) . '-' . $outfit->id . '.' . $newImage->getClientOriginalExtension();
            Storage::putFileAs('public/outfits/', $newImage, $newImageName);
           $newImage->storeAs('public/outfits/', $newImageName);

            $outfit->image = $newImageName;
            $outfit->update();
        }

        $success = trans('app.update-response', ['name' => $outfit->name]);
        return redirect()->route('admin.outfit.show', [$outfit->id, $seller->id])
            ->with([
                'success' => $success,
            ]);
    }


    public function delete($id, $seller_id)
    {

        $outfitseller = Outfitseller::where('outfit_id', $id)->where('seller_id', $seller_id)
            ->firstOrFail();
        if (Auth::user()->seller != null and Auth::user()->seller->id == $seller_id or Auth::user()->role =="admin"){
            // pass;
        }else{
            abort(403);
        }
        $success = trans('app.delete-response', ['name' => $outfitseller->outfit->name]);
        $outfitseller->delete();

        if(Auth::user()->role == 'admin'){
            return redirect()->route('admin.outfits.index')
            ->with([
                'success' => $success,
            ]);
        }else{
                return redirect()->route('admin.outfits.index')
            ->with([
                'success' => $success,
            ]);
            }
    }

    public function show( $outfit_id, $seller_id){
        $outfitseller = Outfitseller::where('outfit_id', $outfit_id)->where('seller_id', $seller_id)
        ->with('seller.location','outfit.values.option', 'outfit.tags', 'outfit.outfitsellers' )->first();
        $outfits = Outfit::where('id', $outfit_id)->with('values', 'tags', 'outfitsellers.seller')
        ->get();
         $outfits;

        return Inertia::render('admin.outfits.show', ['outfitseller'=>$outfitseller,
            'outfits'=>$outfits]);
    }

}
