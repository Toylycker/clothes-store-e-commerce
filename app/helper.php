<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Option;

class Helper
{
    public static function seedwithchildren(Array $array, $parent_id){
        $category = new Category();
        $category->name = $array['name'];
        $category->name_en = $array['name_en'];
        if ($parent_id) {
            $category->category->id = $parent_id;
        }
        $category->save();
        if (isset($array['options'])) {
            foreach ($array['options'] as $option) {
                $find = Option::where('name_en', '$option');
                $category->options->attach($find->id);
                $category->update();
            }
        }
        if (isset($array['children'])) {
            foreach ($array['children'] as $child) {
                Helper::seedwithchildren($child, $category->id);
            }
        }
    }
}
