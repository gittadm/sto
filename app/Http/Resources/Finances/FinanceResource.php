<?php

namespace App\Http\Resources\Finances;

use App\Http\Resources\Departments\DepartmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FinanceResource extends JsonResource
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
            'name' => $this->name,
            'operation_type' => $this->operation_type,
            'sum' => $this->sum,
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
            'finance_group' => FinanceGroupResource::make($this->financeGroup),
            'department' => DepartmentResource::make($this->department)
        ];
    }
}
