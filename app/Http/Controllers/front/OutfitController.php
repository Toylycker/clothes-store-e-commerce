<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Outfit;
use Illuminate\Http\Request;
use App\Models\Option;
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
    public function index(Request $request)
    {


        $request->validate([
            'search' => 'nullable|string|max:30', // search => q
            'v' => 'nullable|array', // values => v
            // 'v.*' => 'nullable|array', // values[] => v.*
            // 'v.*.*' => 'nullable|integer|min:1|distinct', // values[][] => v.*.*
            'd' => 'nullable|boolean', // discount => d
            'n' => 'nullable|boolean', // new => n
            'c' => 'nullable', //category
        ]);

        $category_id = $request->c ? $request->c : null;
        $search = $request->search ?: null;
        $f_values = $request->v ? Value::whereIn('id', $request->v)->with('option')->get()->mapToGroups(function ($value) {

            return [$value->option->id => $value->id];
        }) : [];
        $categories = Category::where('category_id', null)->with('children')->get();


        $options = $category_id ? Option::whereHas('categories', function ($query) use ($category_id) {
            $query->where('id', $category_id);
        })->with('values')->get() : null;


        $outfits = Outfit::when($category_id, function ($query) use ($category_id) {
            return $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('id', $category_id);
            });
        })->when($search, function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->orwhere('search', 'like', '%' . $search . '%');
                $query->orWhere('name', 'like', '%' . $search . '%');});
        })
            ->when($f_values, function ($query, $f_values) {
                return $query->where(function ($query1) use ($f_values) {
                    foreach ($f_values as $f_value) {
                        $query1->whereHas('values', function ($query2) use ($f_value) {
                            $query2->whereIn('id', $f_value);
                        });
                    }
                });
            })->with('values', 'tags', 'seller')->inRandomOrder()->paginate(14, ["*"], 'page')
            ->withQueryString();
        // return $outfits;
        // return CategoryResource::collection($categories);
        return Inertia::render('front/Products', [
            "options" => $options,
            "products" => $outfits,
            "search" => $search,
            "f_values" => collect($f_values)->collapse(),
            "categories" => CategoryResource::collection($categories),
            "category_id" => $category_id
        ]);
    }


    public function show($outfit_id, Request $request)
    {
        $outfit = Outfit::where('id', $outfit_id)
            ->with('seller.user', 'values.option', 'tags', 'outfit_items.variation_options')->first();
        $comments = Comment::where('outfit_id', $outfit->id)->get();
        $variations = Variation::where('outfit_id', $outfit_id)->with('variation_options.outfit_items')->get();
        $flattened = null;
        $chosens = [];


        if ($request->has('options')) {
            $r_options = $request->options ?: null;
            foreach ($request->all() as $key => $value) {
                array_push($chosens, $value);
            }
            $outfititems = OutfitItem::where('outfit_id', $outfit_id)
                ->when($r_options, function ($query) use ($r_options) {
                    $query->where(function ($query1) use ($r_options) {
                        foreach ($r_options as $f_value) {
                            $query1->whereHas('variation_options', function ($query2) use ($f_value) {
                                $query2->where('id', $f_value);
                            });
                        }
                    });
                })->with(['variation_options'])->get();

            $flattened = $outfititems->map(function ($option) {
                $options = [];
                foreach ($option->variation_options as $value) {
                    array_push($options, $value->id);
                }
                return $options;
            })->toArray();

            $flattened = Arr::flatten($flattened);
        }else{
            $outfititems = OutfitItem::where('outfit_id', $outfit_id)->get();
        }

        $minPriceOfItem = $outfititems->pluck('price')->min();
        $maxPriceOfItem = $outfititems->pluck('price')->max();


        return Inertia('front/ShowProduct', [
            'product' => $outfit,
            'comments' => $comments,
            'variations' => $variations,
            'flattened' => $flattened ?: null,
            'chosens' => $chosens,
            'product_items' => $outfititems,
            'min' => $minPriceOfItem,
            'max' => $maxPriceOfItem
        ]);
    }
}






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