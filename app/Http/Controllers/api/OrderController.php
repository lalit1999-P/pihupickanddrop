<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\PlaceOrderRequest;
use App\Http\Resources\api\VehicleVariantResource;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * Product Repository class.
     *
     * @var ProductRepository
     */
    public $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        // $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->orderRepository = $orderRepository;
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            $product = $this->orderRepository->placeOrder($request->all());
            $this->response["message"] = "New service order is created succesfully!";
            $this->response["data"] = $product;
            $this->status = Response::HTTP_OK;
        } catch (\Exception $exception) {
            // return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->response["message"] = $exception->getMessage();
        }
        return $this->returnResponse();
    }

    public function vehicleModel()
    {
        try {
            $model = $this->orderRepository->getModel();
            $this->status = Response::HTTP_OK;
            $this->response["data"] = $model;
            $this->response["message"] = "Vehicle model fetched sucessfully";
        } catch (Exception $th) {
            $this->response["message"] = $th->getMessage();
        }
        return $this->returnResponse();
    }

    public function getVarient(Request $request)
    {
        try {
            $variant = $this->orderRepository->getVarient($request->vehicle_model);
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  VehicleVariantResource::collection($variant);
            $this->response["message"] = "Vehicle variant fetched successfully";
        } catch (Exception $th) {
            $this->response["message"] = $th->getMessage();
        }
        return $this->returnResponse();
    }

    public function getAllLocation()
    {
        try {
            $locations = $this->orderRepository->getLocations();
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  $locations;
            $this->response["message"] = "Locations is fetched successfully";
        } catch (Exception $th) {
            $this->response["message"] = $th->getMessage();
        }
        return $this->returnResponse();
    }

    public function storeOrderImage(Request $request)
    {
        try {
            $order_images = $this->orderRepository->storeOrderImages($request->all());
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  $order_images;
            $this->response["message"] = "Order images in inserted succesfully";
        } catch (Exception $th) {
            $this->response["message"] = $th->getMessage();
        }
        return $this->returnResponse();
    }
    public function orderHistory(Request $request)
    {
        try {
            $OrderHistory = $this->orderRepository->getOrderHistory();
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  $OrderHistory;
            $this->response["message"] = "succesfully Get Order History ";
        } catch (Exception $th) {
            $this->response["message"] = $th->getMessage();
        }
        return $this->returnResponse();
    }
}
