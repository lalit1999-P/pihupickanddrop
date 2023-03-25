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
use App\Models\ServiceOrderImage;
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
    public function uploadsOrderImages($request)
    {
        foreach ($request['img_url'] as $image) {
            $img_name = fileUpload('order_img',  $image);
            $orderImg[] = [
                "service_order_id" => $request['order_id'],
                "image" => $img_name,
                "service_order_image_type" => $request['type'],
            ];
        }
        ServiceOrderImage::insert($orderImg);
        $OrderUpdate = Order::where('id', $request['order_id']);
        $actionStatus = \Config::get('configvalue.ORDER_ACTION_STATUS');
        //dd($actionStatus['PICKUP_IMAGE']);
        if ($request['type'] == $actionStatus['PICKUP_IMAGE']) {
            $OrderUpdate->update(["action_status" => $actionStatus['PICKUP_IMAGE']]);
        } elseif ($request['type'] == $actionStatus['DROP_IMAGE_SERVICE_CENTER']) {
            $OrderUpdate->update(["action_status" => $actionStatus['DROP_IMAGE_SERVICE_CENTER']]);
        } elseif ($request['type'] == $actionStatus['PICKUP_IMAGE_SERVICE_CENTER']) {
            $OrderUpdate->update(["action_status" => $actionStatus['PICKUP_IMAGE_SERVICE_CENTER']]);
        } elseif ($request['type'] == $actionStatus['DROP_IMAGE']) {
            $OrderUpdate->update(["action_status" => $actionStatus['DROP_IMAGE']]);
        } elseif ($request['type'] == $actionStatus['PAYMENT']) {
            $OrderUpdate->update(["action_status" => $actionStatus['PAYMENT']]);
        }
        return true;
    }
    public function getOrderHistory($assign_status)
    {
        // dd($assign_status);
        $Orderlists = Order::where('driver_id', auth()->user()->id)->where('assign_status', $assign_status)->with('DriverUsers', 'Varient', 'vehicleModel', 'location')->get()->toArray();
        $order = [];
        $actionStatus = \Config::get('configvalue.ORDER_ACTION_STATUS');
        foreach ($Orderlists as $Orderlist) {
            // dd($Orderlist['id']);
            $pickup_image = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['PICKUP_IMAGE'])->get();
            $Orderlist['pickup_image'] = isset($pickup_image) ? $pickup_image : [];
            $drop_image_service_center = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['DROP_IMAGE_SERVICE_CENTER'])->get();
            $Orderlist['drop_image_service_center'] = isset($drop_image_service_center) ? $drop_image_service_center : [];
            $pickup_image_service_center = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['PICKUP_IMAGE_SERVICE_CENTER'])->get();
            $Orderlist['pickup_image_service_center'] = isset($pickup_image_service_center) ? $pickup_image_service_center : [];
            $drop_off_image = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['DROP_IMAGE'])->get();
            $Orderlist['drop_off_image'] = isset($drop_off_image) ? $drop_off_image : [];
            $Orderlist['image_base_url'] = 'https://pihupickanddrop.com/images/order_img/';
            $order[] = $Orderlist;
        }
        return $order;
    }
    public function getNewOrder()
    {
        $Orderlists = Order::where('driver_id', auth()->user()->id)->where('assign_status', 1)->with('DriverUsers', 'Varient', 'vehicleModel', 'location')->get()->toArray();
        $order = [];
        $actionStatus = \Config::get('configvalue.ORDER_ACTION_STATUS');

        foreach ($Orderlists as $Orderlist) {
            $pickup_image = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['PICKUP_IMAGE'])->get();
            $Orderlist['pickup_image'] = isset($pickup_image) ? $pickup_image : [];
            $drop_image_service_center = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['DROP_IMAGE_SERVICE_CENTER'])->get();
            $Orderlist['drop_image_service_center'] = isset($drop_image_service_center) ? $drop_image_service_center : [];
            $pickup_image_service_center = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['PICKUP_IMAGE_SERVICE_CENTER'])->get();
            $Orderlist['pickup_image_service_center'] = isset($pickup_image_service_center) ? $pickup_image_service_center : [];
            $drop_off_image = ServiceOrderImage::where('service_order_id', $Orderlist['id'])->select('image')->where('service_order_image_type', $actionStatus['DROP_IMAGE'])->get();
            $Orderlist['drop_off_image'] = isset($drop_off_image) ? $drop_off_image : [];
            $Orderlist['image_base_url'] = 'https://pihupickanddrop.com/images/order_img/';
            $order[] = $Orderlist;
        }
        return $order;
    }

    public function getOrderDetail($order_id)
    {
        $actionStatus = \Config::get('configvalue.ORDER_ACTION_STATUS');

        $Orderlists = Order::where('driver_id', auth()->user()->id)->where("id", $order_id)->with('DriverUsers', 'Varient', 'vehicleModel', 'location', 'pickupImage', 'dropOffImage')->first()->toArray();
        $pickup_image = ServiceOrderImage::where('service_order_id', $Orderlists->id)->select('image')->where('service_order_image_type', $actionStatus['PICKUP_IMAGE'])->get();
        $Orderlists['pickup_image'] = isset($pickup_image) ? $pickup_image : [];
        $drop_image_service_center = ServiceOrderImage::where('service_order_id', $Orderlists->id)->select('image')->where('service_order_image_type', $actionStatus['DROP_IMAGE_SERVICE_CENTER'])->get();
        $Orderlists['drop_image_service_center'] = isset($drop_image_service_center) ? $drop_image_service_center : [];
        $pickup_image_service_center = ServiceOrderImage::where('service_order_id', $Orderlists->id)->select('image')->where('service_order_image_type', $actionStatus['PICKUP_IMAGE_SERVICE_CENTER'])->get();
        $Orderlists['pickup_image_service_center'] = isset($pickup_image_service_center) ? $pickup_image_service_center : [];
        $drop_off_image = ServiceOrderImage::where('service_order_id', $Orderlists->id)->select('image')->where('service_order_image_type', $actionStatus['DROP_IMAGE'])->get();
        $Orderlists['drop_off_image'] = isset($drop_off_image) ? $drop_off_image : [];
        $Orderlists['image_base_url'] = 'https://pihupickanddrop.com/images/order_img/';
        return $Orderlists;
    }
}
