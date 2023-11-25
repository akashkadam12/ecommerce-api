<?php

namespace App\Http\Services\Dress;
use App\Models\DressModel;
use Illuminate\Support\Facades\Log;

class DressServices 
{
	public function bestsSellers($payload)
	{	
		$gender = $payload['gender'];

		return DressModel::bestsSellers($gender);
	}

	public function newArrivals($payload)
	{	
		$gender = $payload['gender'];

		return DressModel::newArrivals($gender);
	}

	public function recommendation($payload)
	{	
		$gender = $payload['gender'];

		return DressModel::recommendation($gender);
	}

	public function newBestsSellers($payload)
	{
	    $gender = $payload['gender'] ?? null;

	    if ($gender && ($gender === 'male' || $gender === 'female' || $gender === 'kid')) {
	        return DressModel::newBestsSellers($gender);
	    } else {
	        return DressModel::allData();
	    }
	}


	public function bestSellersRecommendation($payload)
	{
	    $gender = $payload['gender'] ?? null;

	    if ($gender && ($gender === 'male' || $gender === 'female' || $gender === 'kid')) {
	        return DressModel::bestSellersRecommendation($gender);
	    } else {
	        return DressModel::allDataRecommendation();
	    }
	}
	
	//newArrival
	public function newArrival($payload)
	{
	    $gender = $payload['gender'] ?? null;

	    if ($gender && ($gender === 'male' || $gender === 'female' || $gender === 'kid')) {
	        return DressModel::newArrival($gender);
	    } else {
	        return DressModel::allDataNewArrival();
	    }
	}

	public function recommendations($payload)
	{
	    $gender = $payload['gender'] ?? null;

	    if ($gender && ($gender === 'male' || $gender === 'female' || $gender === 'kid')) {
	        return DressModel::recommendations($gender);
	    } else {
	        return DressModel::allDataRecommendations();
	    }
	}
	


}
