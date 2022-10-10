<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\AppealReasons\AppealReasonResource;
use App\Http\Resources\Cars\SimpleCarResource;
use App\Http\Resources\Clients\SimpleClientResource;
use App\Http\Resources\Departments\DepartmentResource;
use App\Http\Resources\Users\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => SimpleUserResource::make($this->user),
            'client' => SimpleClientResource::make($this->client),
            'appeal_reason' => AppealReasonResource::make($this->appealReason),
            'car' => SimpleCarResource::make($this->car),
            'department' => DepartmentResource::make($this->department),
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
        ];
    }
}
