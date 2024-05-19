<?php

namespace App\Http\Resources;

use App\Models\SaleStructure;
use App\Repositories\Backend\SaleStructureRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class UserClientResource extends JsonResource
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
            'structure_id' => $this->structure_id,
            'structure' => new SaleStructureResource($this->structure)
        ];
    }
}
