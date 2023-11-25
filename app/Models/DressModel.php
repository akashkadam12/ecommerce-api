<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Utility\PostmarkService;

class DressModel extends Model
{
    use HasFactory;

    public static function bestsSellers($gender)
    {
        $post = DB::table('tbl_dress')
                    ->select('dress_id','dress_name','rent_price','review','type')
                    ->where('gender', $gender)
                    ->get();

        return $post;   
    }

    public static function newArrivals($gender)
    {
        $post = DB::table('tbl_dress')
                    ->select('dress_id','dress_name','rent_price','review','type')
                    ->where('gender', $gender)
                    ->get();

        return $post;   
    }

    public static function recommendation($gender)
    {
        $post = DB::table('tbl_dress')
                    ->select('dress_id','dress_name','rent_price','review','type')
                    ->where('gender', $gender)
                    ->get();

        return $post;   
    }

    public static function allData()
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->get();

        return $post;
    }

    public static function newBestsSellers($gender)
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->where('gender', $gender)
            ->get();

        return $post;
    }

    //best_seller
    public static function allDataRecommendation()
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->get();

        return $post;
    }

    public static function bestSellersRecommendation($gender)
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->where('gender', $gender)
            ->get();

        return $post;
    }

    //newArrival
    public static function allDataNewArrival()
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->get();

        return $post;
    }

    public static function newArrival($gender)
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->where('gender', $gender)
            ->get();

        return $post;
    }

    public static function allDataRecommendations()
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->get();

        return $post;
    }

    public static function recommendations($gender)
    {
        $post = DB::table('tbl_dress')
            ->select('dress_id', 'dress_name', 'rent_price', 'review', 'type')
            ->where('gender', $gender)
            ->get();

        return $post;
    }


}

