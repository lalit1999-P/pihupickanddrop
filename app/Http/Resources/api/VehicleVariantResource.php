<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "vehicle_model_id" => $this->vehicle_model,
            "vehicle_model_name" => $this->VehicleModel ? $this->VehicleModel->vehicle_model : "",
            "vehicle_variant" => $this->vehicle_variant,
        ];
    }
}
