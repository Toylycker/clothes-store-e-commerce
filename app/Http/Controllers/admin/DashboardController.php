<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Option;
use App\Models\Tag;
use App\Models\User;
use App\Models\Value;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        // Users
        $users = User::get('role');
        $all_users = $users->count();
        $only_users = $users->where('role','user')->count();
        $sellers = $users->where('role','seller')->count();
        $deliverymans = $users->where('role','deliveryman')->count();
        $admins = $users->where('role','!=','deliveryman')->where('role','!=','seller')->where('role','!=','user')->count();

        $categories = Category::get('id')->count();
        $tags = Tag::get('id')->count();
        $options = Option::get('id')->count();
        $values = Value::get('id')->count();
        $variations = Variation::get('id')->count();
        $variation_options = VariationOption::get('id')->count();

        return Inertia::render('admin/dashboard/index', 
        compact([
            'all_users', 'sellers', 'deliverymans', 'admins', 'only_users',
            'categories','tags','options','values','variations','variation_options',
        ])
    );
    }
}
