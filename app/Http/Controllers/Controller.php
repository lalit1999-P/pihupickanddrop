<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $status = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $response = ['data' => null, 'message' => null];

    public function returnResponse()
    {
        return response()->json($this->response, $this->status);
    }
}
