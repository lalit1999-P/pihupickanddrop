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
use App\Models\DailyCheck;
use Illuminate\Support\Facades\Validator;


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

    public function uploadsOrderImage(Request $request)
    {
        try {
            $order_images = $this->orderRepository->uploadsOrderImages($request->all());
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  $order_images;
            $this->response["message"] = "Order images in inserted succesfully";
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
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'assign_status' => "required",
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403
            ];
            return response($response, 200);
        }

        try {
            $OrderHistory = $this->orderRepository->getOrderHistory($request->assign_status);
            // dd($OrderHistory);
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  $OrderHistory;
            $this->response["message"] = "Succesfully Get Order History ";
        } catch (Exception $th) {
            $this->response["message"] = $th->getMessage();
        }
        return $this->returnResponse();
    }

    public function newOrder(Request $request)
    {
        try {
            $newOrderHistory = $this->orderRepository->getNewOrder();
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  $newOrderHistory;
            $this->response["message"] = "succesfully get new service request";
        } catch (Exception $th) {
            $this->response["message"] = $th->getMessage();
        }
        return $this->returnResponse();
    }
    public function daily_check(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'date' => "required",

        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        $daily_check = new DailyCheck();
        $daily_check->user_id = auth()->user()->id;
        $daily_check->date = $request->date;
        $daily_check->shower = $request->shower;
        $daily_check->charger = $request->charger;
        $daily_check->power_bank = $request->power_bank;
        $daily_check->uniform     = $request->uniform;
        $daily_check->perfume = $request->perfume;
        $daily_check->pen = $request->pen;
        $daily_check->swaping_machine = $request->swaping_machine;
        $daily_check->qr_code = $request->qr_code;
        $daily_check->id_card = $request->id_card;
        $daily_check->clean_shave = $request->clean_shave;

        $daily_check->save();
        $message = "Saved Successfully.";
        $response = [
            'message' => $message,
            'dailyCheck' => $daily_check,
            'status' => 200
        ];
        return response($response, 200);
    }

    public function orderDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => "required",
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403
            ];
            return response($response, 200);
        }


        try {
            $order_detail = $this->orderRepository->getOrderDetail($request->order_id);
            $this->status = Response::HTTP_OK;
            $this->response["data"] =  $order_detail;
            $this->response["message"] = "order details fetched successfully.";
        } catch (Exception $e) {
            $this->status = Response::HTTP_OK;
            $this->response["message"] = $e->getMessage();
        }

        return $this->returnResponse();
    }
}
