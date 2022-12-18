<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\LocationResource;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function locations(Request $request)
    {
        try {
            $locations = Location::select("id", "location")->latest()->get();
            $this->response['data'] =  LocationResource::collection($locations);
            $this->response["message"] = "Location Fetched Sussfully";
        } catch (Exception $e) {
            $this->response["message"] = $e->getMessage();
        }

        $this->status = Response::HTTP_OK;
        return $this->returnResponse();
    }
}
