<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    //
    public function allCategory(Request $request)
    {
        try {
            $category = Category::latest()->get();

            $this->response["message"] = "Category data fetched successfully";
            $this->response['data'] = CategoryResource::collection($category);
            $this->status = Response::HTTP_OK;
        } catch (Exception $e) {
            $this->response["message"] = $e->getMessage();
        }
        return $this->returnResponse();
    }
}
