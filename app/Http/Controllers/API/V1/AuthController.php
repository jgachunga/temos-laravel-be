<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Validator;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use AfricasTalking\SDK\AfricasTalking;

use Hash;
use Illuminate\Support\Facades\DB as FacadesDB;

class AuthController extends Controller
{
    public function register (Request $request) {

        $validator = Validator::make($request->all(), [
            // 'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all(), "Message"=>"Failed registration", 'Code'=>422, "Status"=> "Failed"]);
        }

        $request['password']=Hash::make($request['password']);
        $user = User::create($request->toArray());

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['Code'=>201, "Status"=> "Success", "Message"=>"Successful registration", 'token' => $token];

        return response()->json($response);

    }
    public function login (Request $request) {
        $user=null;
        if(isset($request->email)){
            $user = User::where('email', $request->email)->first();
        }else if(isset($user->name)){
            $user = User::where('first_name', $request->name)->first();
        }


        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ["Code" => 201, "Status"=>"Success",  "Message" =>'Successful login', 'token' => $token, "user" => $user];
                return response()->json($response);
            } else {
                $response = ["Code" => 422, "Status"=>"Error",  "Message" =>'Password mismatch'];
                return response()->json($response);
            }

        } else {
            $response = ["Code" => 422, "Status"=>"Error",  "Message" =>'User does not exist'];
            return response()->json($response);
        }

    }
    public function loginCode (Request $request) {
        Log::debug($request->all());
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'verification_code' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all(), "Message"=>"Failed login", 'Code'=>422, "Status"=> "Failed"]);
        }

        $inputarr=$request->all();
        $user=null;
        if(isset($inputarr['username'])){
            $user = User::where('username', $inputarr['username'])->first();
        }

        if ($user) {

            if (Hash::check($inputarr['verification_code'], $user->password)) {
                // $userTokens = $user->tokens;
                // foreach($userTokens as $token) {
                //     $token->revoke();
                // }

                $token = $user->createToken('Laravel Password Grant Client')->accessToken;

                $response = ["Code" => 201, "Status"=>"Success",  "Message" =>'Successful login', 'token' => $token, "user" => $user];
                return response()->json($response);
            } else {
                $response = ["Code" => 422, "Status"=>"Error",  "Message" =>'Password mismatch'];
                return response()->json($response);
            }

        } else {
            $response = ["Code" => 422, "Status"=>"Error",  "Message" =>'User does not exist'];
            return response()->json($response);
        }

    }
    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        $response = ['Code'=>201, "Message"=>'You have been succesfully logged out!'];
        return response()->json($response);

    }
    public function sms (Request $request) {
        $AT = new AfricasTalking(
            env('AFRICASTALKING_USERNAME'),
            env('AFRICASTALKING_API_KEY')
        );
        // Get one of the services
        $phone = '+254706387067';
        $AT->sms()
            ->send([
                'to' => $phone,
                'message' => 'Welcome'
            ]);
    }
    public function registerSalesRep (Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|regex:/(254)[0-9]{9}/|max:255',
            'structure_id' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all(), "Message"=>"Failed registration", 'Code'=>422, "Status"=> "Failed"]);
        }
        $input_array=$request->all();
        $token = $input_array['code'];
        $input_array['password']=Hash::make($token);
        $input_array['is_rep'] = 1;
        $structure_id = 1;
        if(isset($input_array['structure_id'])){
            $structure_id = $input_array['structure_id'];
        }
        DB::beginTransaction();
        try{
            $user = User::create($input_array);
            $user->sendToken($input_array['phone'], $token, $structure_id);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            $error_obj=array('Code' => 422,'Status'=>'Error','Message'=> $e->getMessage());
            return response()->json($error_obj);
        }
        $success_obj=array('Code' => 201,'Status'=>'Success','Message'=> 'Message sent successfully' );
        return response()->json($success_obj);

    }
    public function updateUser(Request $request) {
        $input_array=$request->all();
        $avatarLocation = $input_array['avatar'];
        $user_id = Auth::guard('api')->user()->id;
        $user = User::find($user_id);
        $user->avatar_location=$avatarLocation;
        $user->save();
    }
}
