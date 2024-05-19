<?php

namespace App\Http\Requests\API\V1;

use App\Models\UserRoute;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserRouteAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = UserRoute::$rules;
        
        return $rules;
    }
}