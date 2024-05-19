<?php

namespace App\Http\Resources;

use App\Models\SaleStructure;
use App\Models\SubCustomer;
use App\Repositories\Backend\SaleStructureRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'sub_domain' => $this->sub_domain,
            'address' => $this->address,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'channel_id' => $this->channel_id,
            'route_id' => $this->route_id,
            'gpstimestamp' => $this->gpstimestamp,
            'geoaddress' => $this->geoaddress,
            'can_edit' => $this->can_edit,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'visited_at' => $this->visited_at,
            'route' => new RouteResource($this->route),
            'channel' => new ChannelResource($this->channel),
            'subCustomers' => SubCustomerResource::collection($this->sub_customers)
        ];
    }
}
