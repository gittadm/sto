<?php

namespace App\Http\Resources\Finances;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinanceCollection extends ResourceCollection
{
    public $collects = FinanceResource::class;

    public static $wrap = 'finances';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
