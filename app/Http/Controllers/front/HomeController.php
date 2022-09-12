<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Models\Outfit;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Age;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use App\Models\Seller;
use App\Models\OutfitSeller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(){

        // $outfits = OutfitSeller::with('seller.location','outfit.values.option', 'outfit.tags')->get();
        // return $outfits;

        return view('front.home.index');
    }

    public function categories(Request $request){
        $category_id = $request->c;
        $f_values = collect([1]);

        $categories = Category::where('category_id', null)->with('children','options.values')->get();
        $options = $category_id?Option::whereHas('categories', function ($query) use ($category_id){
            $query->where('id', $category_id);
        })->with('values')->get():null;

        return view('front.categories.categories', compact(['categories', 'options', 'f_values']));
    }

    

    public function language($key)
    {
        if ($key == 'en') {
            session()->put('locale', 'en');
        } else {
            session()->put('locale', 'tm');
        }

        return redirect()->back();
    }


    public function results(Request $request){
        if($request->has('a')){
            $a = $request->a;
            $outfits = Outfit::whereHas('age', function ($query) use ($a){
                return $query->where('id', $a);
            })->with('values', 'tags', )->inRandomOrder()->paginate(34,["*"], 'page')
            ->withQueryString();
        }else if($request->has('t')){
            $t = $request->t;
            $outfits = Outfit::whereHas('tags', function ($query) use ($t){
                return $query->where('id', $t);
            })->with('values', 'tags', )->inRandomOrder()->paginate(34,["*"], 'page')
            ->withQueryString();
        }
        

        return view('front.home.results',  ['outfits'=>$outfits]);
    }



}
