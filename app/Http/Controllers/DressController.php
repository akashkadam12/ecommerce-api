<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Dress\DressServices;
use App\Http\Services\Utility\ResponseUtility;
use Validator;

class DressController extends Controller
{
    public function homeScreen(Request $request)
    {
        $payload = $request->all();

        $dressServices = new DressServices();

        $genderRules = ['gender' => 'required'];

        $genderValidation = Validator::make($request->all(), $genderRules);
        if($genderValidation->fails())
        {
            return ResponseUtility::respondWithError(4006, null);
        }
 
        $bestsSellers = $dressServices->bestsSellers($payload);
        $newArrivals = $dressServices->newArrivals($payload);
        $recommendation = $dressServices->recommendation($payload);

        return array('bests_sellers' => $bestsSellers, 'new_arrivals' => $newArrivals, 'recommendation' => $recommendation);

    }

    public function newBestsSellers(Request $request)
    {   
        $payload = $request->all();
        
        $dressServices = new DressServices();

        // Assuming 'gender' is one of the keys in the payload
        $gender = $payload['gender'] ?? null;

        if ($gender && !in_array($gender, ['male', 'female', 'kid'])) {
            return ResponseUtility::respondWithError(4006, null);
        }
        
        $newBestsSellers = $dressServices->newBestsSellers($payload);
        $bestSellersRecommendation = $dressServices->bestSellersRecommendation($payload);
        
        return array('best_sellers' => $newBestsSellers, 'recommendation' => $bestSellersRecommendation);
    }

    //newArrival
    public function newArrival(Request $request)
    {   
        $payload = $request->all();
        
        $dressServices = new DressServices();

        // Assuming 'gender' is one of the keys in the payload
        $gender = $payload['gender'] ?? null;

        if ($gender && !in_array($gender, ['male', 'female', 'kid'])) {
            return ResponseUtility::respondWithError(4006, null);
        }
        
        $newArrival = $dressServices->newArrival($payload);
        $recommendations = $dressServices->recommendations($payload);
        
        return array('new_arrival' => $newArrival, 'recommendation' => $recommendations);
    }

}

