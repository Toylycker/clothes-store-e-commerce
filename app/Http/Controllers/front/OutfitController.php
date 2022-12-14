<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Outfit;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Age;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Image;
use App\Models\OutfitItem;
use Illuminate\Support\Str;
use App\Models\Seller;
use App\Models\Value;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
            // 'v.*' => 'nullable|array', // values[] => v.*
            // 'v.*.*' => 'nullable|integer|min:1|distinct', // values[][] => v.*.*
            'd' => 'nullable|boolean', // discount => d
            'n' => 'nullable|boolean', // new => n
            'c' => 'nullable'
        ]);
        $category_id = $request->c?$request->c:null;
        $search = $request->q ?: null;
        $f_values = $request->v? Value::whereIn('id', $request->v)->with('option')->get()->mapToGroups(function ($value) {

            return [$value->option->id=>$value->id];
        }): [];
        $categories = Category::where('category_id', null)->with('children')->get();


        $options = $category_id?Option::whereHas('categories', function ($query) use ($category_id){
            $query->where('id', $category_id);
        })->with('values')->get():null;


        $outfits = Outfit::when($category_id, function ($query) use($category_id){
            return $query->whereHas('categories', function ($query) use ($category_id){
                $query->where('id', $category_id);
            });
        })->when($search, function ($query) use($search){
            return $query->where('search', 'like', '%' . $search . '%');
        })
        ->when($f_values, function ($query, $f_values) {
            return $query->where(function ($query1) use ($f_values) {
                foreach ($f_values as $f_value) {
                    $query1->whereHas('values', function ($query2) use ($f_value) {
                        $query2->whereIn('id', $f_value);
                    });
                }
            });
        })->with('values', 'tags', 'seller')->inRandomOrder()->paginate(14,["*"], 'page')
        ->withQueryString();
        // return $outfits;
        // return CategoryResource::collection($categories);
                return Inertia::render('front/Products', [
                    "options" => $options,
                    "products" => $outfits,
                    "search" => $search,
                    "f_values" => collect($f_values)->collapse(),
                    "categories"=>CategoryResource::collection($categories),
                    "category_id" => $category_id
                ]);
    }


    public function show( $outfit_id, Request $request){
        $outfit = Outfit::where('id', $outfit_id)
        ->with('seller','values.option', 'tags','outfit_items.variation_options')->first();
        $comments = Comment::where('outfit_id', $outfit->id)->get();
        $variations = Variation::where('outfit_id', $outfit_id)->with('variation_options.outfit_items')->get();
        $flattened = null;
        $outfititems = null;
        $chosens = [];

        if($request->has('options')){
        $r_options = $request->options?:null;
        foreach($request->all() as $key => $value) {
            array_push($chosens, $value);
        }
        $outfititems = OutfitItem::where('outfit_id', $outfit_id)
        ->when($r_options,function ($query) use ($r_options){
            $query->where(function ($query1) use ($r_options) {
            foreach ($r_options as $f_value) {
                $query1->whereHas('variation_options', function ($query2) use ($f_value) {
                    $query2->where('id', $f_value);
                });
            }
        });})
        // ->when($r_options,function ($query) use ($r_options){
        //     foreach ($r_options as $value) {
        //         return $query->whereHas('variation_options', function ($query) use ($value){
        //                 $query->where('id', $value);});
        //     }
        // })
        ->with(['variation_options'])->get();

        $flattened = $outfititems->map(function ($option) {
            $options=[];
            foreach ($option->variation_options as $value) {
                    array_push($options, $value->id);

            }
            return $options;
        })->toArray();
        // $flattened = 

        $flattened = Arr::flatten($flattened);
        
        // $flattened = array_unique($flattened);
        // return $flattened;
        }

        return Inertia('front/ShowProduct', [
            'product'=>$outfit,
            'comments' =>$comments,
            'variations' =>$variations,
            'flattened' => $flattened?:null,
            'chosens' =>$chosens,
            'product_items'=>$outfititems
        ]);
    }

    public function edit($id, $seller_id)
    {
        if (Auth::user()->seller != null and Auth::user()->seller->id == $seller_id or Auth::user()->role =="admin"){
            // pass;
        }else{
            abort(403);
        }
        $outfit = Outfit::where('id', $id)
            ->with(['seller'])
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
            'ages' => $ages,
            'tags' => $tags,
            'options' => $options,
            'outfit' => $outfit,
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
        $outfit->description = $request->description ?: null;
        $outfit->description_en = $request->description_en ?: null;
        $outfit->price = $request->price;
        $outfit->stock = $request->stock;
        $outfit->discount_percent = $request->discount_percent;
        $outfit->credit = $request->credit ?: 0;
        $outfit->recommended = $request->recommended ?: 0;
        $outfit->update();
        $outfit->update();

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
        return redirect()->route('outfit.show', [$outfit->id])
            ->with([
                'success' => $success,
            ]);
    }


    public function delete($id)
    {

        $outfit = outfit::where('id', $id)->with('seller')
            ->firstOrFail();
        if (Auth::user()->seller != null and Auth::user()->seller->id == $outfit->seller->id or Auth::user()->role =="admin"){
            // pass;
        }else{
            abort(403);
        }
        $success = trans('app.delete-response', ['name' => $outfit->name]);
        $outfit->delete();

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
        $outfit = Outfit::get();
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
            'sellers' => $sellers,
        ]);
    }

    public function store(Request $request)
    {   
        $request->validate([
            'description' => 'nullable|string|max:2550',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0',
            'discount_datetime_start' => 'nullable|date',
            'discount_datetime_end' => 'nullable|date',
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
    $outfit->age_id = $age->id;
    $outfit->name = $name;
    $outfit->name_en = $name_en;
    $outfit->slug = Str::slug($name) . '-' . $outfit->id;
    $outfit->recommended = $request->recommended ?: 0;
    $outfit->seller_id = $seller->id;
    $outfit->description = $request->description ?: null;
    $outfit->description_en = $request->description_en ?: null;
    $outfit->price = $request->price;
    $outfit->stock = $request->stock;
    $outfit->discount_percent = $request->discount_percent;
    $outfit->discount_datetime_start = Carbon::parse($request->discount_datetime_start)->toDateTimeString();
    $outfit->discount_datetime_end = Carbon::parse($request->discount_datetime_end)->toDateTimeString();
    $outfit->credit = $request->credit ?: 0;
    $outfit->recommended = $request->recommended ?: 0;
    $outfit->save();

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
        return redirect()->route('show', [$outfit->id])
            ->with([
                'success' => $success,
            ]);
    }



    public function check(){
        $image = Image::where('id', 1)->first();

        return view('front.check', compact('image'));
    }
}


// $('@foreach ($outfit->variations as $variation) <h3 > {{ $variation->name }} < /h3> <br ><div class = "row" >@foreach ($variation->variation_options as $ooption)<div class = "col btn border" >@if ($ooption->outfit_items->count() > 0)<a href ="{{ route('variationchoosing', ['variation_id' => $variation->id, 'option_id' => $ooption->id, 'outfit_id' => $outfit->id]) }}" >{{ $ooption->option }} </a>@else<p class = "bg-secondary" > {{ $ooption->option }} </p>@endif </div>@endforeach </div>@endforeach').appendTo('{{ '#modal_body_' . $outfit->id }}');

                // @foreach ($outfit->variations as $variation) <
//                                     h3 > {{ $variation->name }} < /h3> <
//                                     br >
//                                     <
//                                     div class = "row" >
//                                     @foreach ($variation->variation_options as $ooption)
//                                         <
//                                         div class = "col btn border" >
//                                             @if ($ooption->outfit_items->count() > 0)
//                                                 <
//                                                 a href =
//                                                     "{{ route('variationchoosing', ['variation_id' => $variation->id, 'option_id' => $ooption->id, 'outfit_id' => $outfit->id]) }}" >
//                                                     {{ $ooption->option }} <
//                                                     /a>
//                                             @else
//                                                 <
//                                                 p class = "bg-secondary" > {{ $ooption->option }} <
//                                                     /p>
//                                             @endif <
//                                             /div>
//                                     @endforeach <
//                                     /div>
//                                 @endforeach





// Handling before start 
    // function variation_choosing(Request $request){//instead of ids, there should be request->options which contains list og options. one from each variation
    //     $r_option0 = $request->option0?:null;
    //     $r_option1 = $request->option1?:null;
    //     $r_option2 = $request->option2?:null;
    //     $r_option3 = $request->option3?:null;
    //     $r_option4 = $request->option4?:null;
    //     $r_option5 = $request->option5?:null;
    //     $outfititems = OutfitItem::when($r_option0,function ($query) use ($r_option0){
    //         $query->whereHas('variation_options', function ($query) use ($r_option0){
    //                 $query->where('id', $r_option0);

    //         });
    //     })->when($r_option1,function ($query) use ($r_option1){
    //         $query->whereHas('variation_options', function ($query) use ($r_option1){
    //                 $query->where('id', $r_option1);

    //         });
    //     })->when($r_option2,function ($query) use ($r_option2){
    //         $query->whereHas('variation_options', function ($query) use ($r_option2){
    //                 $query->where('id', $r_option2);

    //         });
    //     })->when($r_option3,function ($query) use ($r_option3){
    //         $query->whereHas('variation_options', function ($query) use ($r_option3){
    //                 $query->where('id', $r_option3);

    //         });
    //     })->when($r_option4,function ($query) use ($r_option4){
    //         $query->whereHas('variation_options', function ($query) use ($r_option4){
    //                 $query->where('id', $r_option4);

    //         });
    //     })->when($r_option5,function ($query) use ($r_option5){
    //         $query->whereHas('variation_options', function ($query) use ($r_option5){
    //                 $query->where('id', $r_option5);

    //         });
    //     })
    //     ->with(['variation_options'])->get()->map(function ($option) {
    //         $options=[];
    //         foreach ($option->variation_options as $value) {
    //                 array_push($options, $value->id);

    //         }
    //         return $options;
    //     });

    //     $flattened = Arr::flatten($outfititems);
    //     $flattened = array_unique($flattened);

    //     return $flattened;

    //     $outfititemswithalloptions = OutfitItem::whereHas('variation_options', function ($query) use ($flattened){
    //         $query->whereIn('id', $flattened);
    //     })
    //     ->with('variation_options')
    //     ->get()
    //     ->map(function ($option) {
    //         $ooptions=[];
    //         foreach ($option->variation_options as $value2) {
    //             array_push($ooptions, $value2->option);
    //         }
    //         return $ooptions;
    //     });
    //     $ready = Arr::flatten($outfititemswithalloptions);
    //     return $ready;

    //     return redirect()->back()->with(['needyOptions'=>$ready]);
    // }

    // function variations(Request $request){
    //     $variations = Variation::where('outfit_id', $request->outfit_id)->with('variation_options.outfit_items')->get();

    //     return response()->json($variations);

    // }

// Handling before end 