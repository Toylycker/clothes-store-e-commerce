<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Outfit;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Age;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Image;
use Illuminate\Support\Str;
use App\Models\Seller;
use App\Models\OutfitSeller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OutfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $request->validate([
            'q' => 'nullable|string|max:30', // search => q
            'v' => 'nullable|array', // values => v
            'v.*' => 'nullable|array', // values[] => v.*
            'v.*.*' => 'nullable|integer|min:1|distinct', // values[][] => v.*.*
            'd' => 'nullable|boolean', // discount => d
            'n' => 'nullable|boolean', // new => n
            't' => 'nullable|boolean', // credit => t
            'ages' => 'nullable|array',
        ]);

        $search = $request->q ?: null;
        $f_values = $request->has('v') ? $request->v : [];
        $f_ages = $request->has('ages') ? $request->ages : [];
        $options = Option::with('values')->OrderBy('sort_order')->get();
        $ages = Age::get();

        $pants  = $search==null && $f_values==null && $f_ages ==null?Outfit::with('values', 'tags', 'seller')->whereHas('values', function ($query) {
            $query->where('id', '19');})->take(6)->get():null;
        $jeansies  = $search==null && $f_values==null && $f_ages ==null?Outfit::with('values', 'tags', 'seller')->whereHas('values', function ($query) {
            $query->where('id', '24');})->take(6)->get():null;
        $dresses  = $search==null && $f_values==null && $f_ages ==null?Outfit::with('values', 'tags', 'seller')->whereHas('values', function ($query) {
            $query->where('id', '23');})->take(6)->get():null;
        $jumpers  = $search==null && $f_values==null && $f_ages ==null ?Outfit::with('values', 'tags', 'seller')->whereHas('values', function ($query) {
            $query->where('id', '27');})->take(6)->get():null;
        $suits  = $search==null && $f_values==null && $f_ages ==null?Outfit::with('values', 'tags', 'seller')->whereHas('values', function ($query) {
                $query->where('id', '30');})->take(6)->get():null;
        $t_shirts  = $search==null && $f_values==null && $f_ages ==null?Outfit::with('values', 'tags', 'seller')->whereHas('values', function ($query) {
            $query->where('id', '20');})->take(6)->get():null;

        $outfits = $pants?0:Outfit::when($search, function ($query) use($search){
            return $query->where('search', 'like', '%' . $search . '%');
        })
        ->when($f_ages, function ($query) use ($f_ages){
            return $query->whereIn('age_id', $f_ages);
        })
        ->when($f_values, function ($query, $f_values) {
            return $query->where(function ($query1) use ($f_values) {
                foreach ($f_values as $f_value) {
                    $query1->whereHas('values', function ($query2) use ($f_value) {
                        $query2->whereIn('id', $f_value);
                    });
                }
            });
        })->with('values', 'tags', 'seller')->inRandomOrder()->paginate(54,["*"], 'page')
        ->withQueryString();
                return view('front.outfits.index', [
                    'options' => $options,
                    "pants" => $pants,
                    "jinsies" => $jeansies,
                    "dresses" => $dresses,
                    "jumpers" => $jumpers,
                    "suits" => $suits,
                    "t_shirts" => $t_shirts,
                    "outfits" => $outfits,
                    "search" => $search,
                    "f_values" => collect($f_values)->collapse(),
                    'f_ages' => collect($f_ages),
                    'ages' =>$ages
                ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outfit  $outfit
     * @return \Illuminate\Http\Response
     */
    public function show( $outfit_id, $seller_id){
        $outfit = Outfit::findOrFail($outfit_id)
        ->with('seller','values.option', 'tags')->first();
        $comments = Comment::where('outfit_id', $outfit->id)->get();

        return view('front.outfits.show', [
            'outfit'=>$outfit,
            'comments' =>$comments
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
        $ages = Age::orderBy('id')
            ->get();
        $tags = Tag::orderBy('id')
            ->get();
        $options = Option::with(['values'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('front.outfits.edit', [
            'outfit' => $outfit,
            'ages' => $ages,
            'tags' => $tags,
            'options' => $options,
            'outfitseller' => $outfitseller,
            'sellers' => $sellers,
        ]);
    }


    public function update(Request $request, $id)
    {   
        $outfit = Outfit::where('id', $id)
        ->with('seller')
            ->firstOrFail();
        $request->validate([
            'age' => 'integer|min:1',
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
        $seller = Seller::findOrFail(Auth::user()->seller->id);
        $age = Age::findOrFail($request->age_id);
        $name = $request->name;
        $name_en = $request->name_en;

        
        $outfit->age_id = $age->id;
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
        return redirect()->route('outfit.show', [$outfit->id, $seller->id])
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
            return redirect()->route('outfits.home')
            ->with([
                'success' => $success,
            ]);
        }else{
                return redirect()->route('outfits.home')
            ->with([
                'success' => $success,
            ]);
            }
    }


    public function create()
    {
        $sellers = Seller::get();
        $outfit = Outfit::with(['outfitsellers.seller'])
            ->get();
        $outfitseller = Outfitseller::with(['outfit'])
            ->get();
        $ages = Age::orderBy('id')
            ->get();
        $tags = Tag::orderBy('id')
            ->get();
         $options = Option::with(['values'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('front.outfits.create', [
            'outfit' => $outfit,
            'ages' => $ages,
            'tags' => $tags,
            'options' => $options,
            'outfitseller' => $outfitseller,
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
    $age = Age::findOrFail($request->age_id);
    $seller = Seller::findOrFail(Auth::user()->seller->id);
    $name = $request->name;
    $name_en = $request->name_en;
    $search = $name . $name_en . $age->name ;

    // outfit
    $outfit = new Outfit;
    $outfitseller = new Outfitseller;
    $outfit->age_id = $age->id;
    $outfit->name = $name;
    $outfit->name_en = $name_en;
    $outfit->slug = Str::slug($name) . '-' . $outfit->id;
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
    foreach($outfit->values as $value){
        $search .= $value->name;
        $search .= $value->name_en;
    }

    foreach($outfit->tags as $tag){
        $search .= $tag->name;
        $search .= $tag->name_en;
    }
    $outfit->search  = $search;


    // image
    if ($request->has('image')) {
        $newImage = $request->file('image');
        $newImageName = Str::random(10) . '-' . $outfit->id . '.' . $newImage->getClientOriginalExtension();
        Storage::putFileAs('public/oufits/', $newImage, $newImageName);
           $newImage->storeAs('public/outfits/', $newImageName);

        $outfit->image = $newImageName;
        $outfit->update();
    }

    $outfit->update();

    $success = trans('app.update-response', ['name' => $outfit->name]);

        $success = trans('app.store-response', ['name' => $outfit->name]);
        return redirect()->route('outfit.show', [$outfit->id, $seller->id])
            ->with([
                'success' => $success,
            ]);
    }



    public function check(){
        $image = Image::where('id', 1)->first();

        return view('front.check', compact('image'));
    }
}
