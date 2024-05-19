<?php

namespace App\Http\Resources;

use App\Models\QuestionOption;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'form_id' => $this->form_id,
            'type' => $this->type,
            'required' => $this->required,
            'label' => $this->label,
            'options' => QuestionOptionResource::collection($this->options),
        ];
    }
}
