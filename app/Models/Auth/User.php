<?php

namespace App\Models\Auth;
use App\Models\SalesRep;

use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use Laravel\Passport\HasApiTokens;
use AfricasTalking\SDK\AfricasTalking;
use App\Scopes\StructureScope;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User.
 */
class User extends BaseUser
{
    use UserAttribute,
        UserMethod,
        UserRelationship,
        HasApiTokens,
        Notifiable,
        HasRoles,
        UserScope;

        protected $guard_name ='api';

        public function sendToken($phone, $token, $structure_id)
        {
        $user = User::where('phone', '=', $phone)->firstOrFail();
        $logged_structure_id = Auth::guard('api')->user()->logged_structure_id;
        if(isset($logged_structure_id)&&$logged_structure_id!==null){
            $structure_id = $logged_structure_id;
        }
            if($user!=null){
                $rep=SalesRep::create([
                    'name' => $user->username,
                    'user_id' => $user->id,
                    'structure_id'=> $structure_id
                ]);
                $userupdate=User::update([
                    'verification_code' => $token,
                    'rep_id' => $rep->id,
                    'verified' => false,
                    'structure_id'=> $structure_id
                ]);
            }
        //sms notification
        try{
        $AT = new AfricasTalking(
            env('AFRICASTALKING_USERNAME'),
            env('AFRICASTALKING_API_KEY')
        );
        // Get one of the services
        $AT->sms()
            ->send([
                'to' => $phone,
                'message' => 'Dear '.$user->username.', Use this code to login to your Temos App account : '.$token
            ]);
        }catch(Exception $e){
            Log::debug($e);
        }

        }
        public function sendCustomerToken($phone, $token)
        {
        // Session::put('token', $token);
        $user = User::where('phone', '=', $phone)->firstOrFail();

            if($user!=null){
                $user=User::update([
                    'verification_code' => $token,
                    'verified' => false,
                    'is_customer' => true
                ]);
            }
        //sms notification
        $AT = new AfricasTalking(
            env('AFRICASTALKING_USERNAME'),
            env('AFRICASTALKING_API_KEY')
        );
        // Get one of the services
        $AT->sms()
            ->send([
                'to' => $phone,
                'message' => 'Use this code to login to your HAZINA APP account : '.$token
            ]);

    }
    public function validateToken($token, $phone)
    {
     $user = User::where('phone', '=', $phone)->first();
        $validToken = $user->verification_code;
        if($token == $validToken) {
            // Session::forget('token');
            $user=User::update([
                'verified' => true,
            ]);

            return true;
        } else {
            return false;
        }
    }
    public function user_route()
    {
        return $this->hasMany(\App\Models\UserRoute::class, 'user_id', 'id');
    }
    public function target()
    {
        return $this->hasMany(\App\Models\UserTarget::class, 'user_id', 'id');
    }
    public function structure()
    {
        return $this->hasOne(\App\Models\SaleStructure::class, 'id', 'structure_id');
    }
}
