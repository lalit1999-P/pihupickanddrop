<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use App\Interfaces\CrudInterface;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderImage;
use App\Models\User;
use App\Models\VehicleModel;
use App\Models\VehicleVariant;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User | null $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // $this->user = Auth::user();
    }


    public function placeOrder(array $data): Order
    {
        $data['driver_id'] = auth()->user()->id;
        return Order::create($data);
    }

    public function getModel(): ?object
    {
        return VehicleModel::latest()->get();
    }

    public function getVarient(int $modelId): ?object
    {
        return VehicleVariant::with('VehicleModel')->where("vehicle_model", $modelId)->latest()->get();
    }

    public function getLocations(): ?object
    {
        return Location::latest()->get();
    }

    public function storeOrderImages($request)
    {
        // dd($request);   
        $orderId = $request['order_id'] ?? "";
        $type = $request['type'] ?? "";
        foreach ($request['img_url'] as $img) {
            $img_name = fileUpload('order_img', $img);
            $orderImg[] = [
                "order_id" => $orderId,
                "img_url" => $img_name,
                "type" => $type,
            ];
        }

        $orderImgData =  OrderImage::insert($orderImg);
        if ($orderImgData) {
            return OrderImage::where("type", $type)->where("order_id", $orderId)->latest()->get();
        } else {
            return false;
        }
    }
    public function getOrderHistory($assign_status='1')
    {
        return Order::where('driver_id', auth()->user()->id)->where('assign_status',$assign_status)->with('DriverUsers', 'Varient', 'vehicleModel', 'location')->get();
    }
    public function getNewOrder()
    {
        return Order::where('driver_id', auth()->user()->id)->where('status', 0)->with('DriverUsers', 'Varient', 'vehicleModel', 'location')->get();
    }

    public function getOrderDetail($order_id)
    {
        return Order::where('driver_id', auth()->user()->id)->where("id", $order_id)->with('DriverUsers', 'Varient', 'vehicleModel', 'location')->first();
    }
   
}
