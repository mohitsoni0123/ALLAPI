<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNewModeRequest;
use App\Http\Requests\UpdateNewModeRequest;
use App\Models\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
class ServicesController extends Controller
{
    public function index(Request $request)
    {
    	if($request->email==''){
    		return json_encode(["status"=>"false", "message" => "Please Enter Username","data"=>[]],401);
    	}

    	if($request->password==""){
    		return json_encode(["status"=>"false", "message" => "Please Enter Password","data"=>[]],401);
    	}
        // $data = User::where('email',$request->email)->where('password',md5($request->password))->first();
        // print_r($data );die;
       // print_r( ['email' => $request->email, 'password' => $request->password]); die;
    	if(Auth::attempt(['email' => $request->email, 'password' =>$request->password]))
        { 
		$data = Auth::user();
		$data['token'] =  $data->createToken('A')->plainTextToken; 
		return json_encode(["status"=>"true", "message" => "Login Successfully ...","data" => $data],200);
        }
        else{
        	return json_encode(["status"=>"false", "message" => "Invalid Crediantial","data"=>[]],401);
        }
    }

    public function Register(Request $request)
    { //echo $request->email; die;
          $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
          $email_payyren = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'; 
       if($request->email==''){
            return json_encode(["status"=>"false", "message" => "Please Enter Username","data"=>[]],401);
        }

        if($request->password==""){
            return json_encode(["status"=>"false", "message" => "Please Enter Password","data"=>[]],401);
        }
        if(!preg_match($email_payyren,$request->email)){
            return json_encode(["status"=>"false", "message" => "Please Check Email","data"=>[]],401);
        }
         $email = User::where('email',$request->email)->count();
        if($email >0){
            return json_encode(["status"=>"false", "message" => "This Email Already Exist","data"=>[]],401);
        }
        // if($request->password!=$request->c_password){
        //      return json_encode(["status"=>"false", "message" => "Please Check Confirm Password","data"=>[]],401);
        // }
        if( !preg_match($password_pattern,$request->password)){
             return json_encode(["status"=>"false", "message" => "Password must have At least 8 charecter length with mimimum 1 uppercase, 1 lowercase, 1 number and 1 special characters.\n","data"=>[]],401);
        }
      $data = ['name' => $request->name,
       'email' => $request->email,
       'password' =>Hash::make($request->password),
       'latit'=> $request->Latitude,
       'longit' =>$request->Longitude,
       'Address' =>$request->Address ];
      $data = User::insertGetId($data);
      if($data){
        $CurrentData = User::where('id',$data)->first();
        if(Auth::attempt(['email' => $request->email, 'password' =>$request->password]))
        { 
        $data = Auth::user();
        $CurrentData['token']= $data->createToken('ABC')->plainTextToken; 
       return json_encode(["status"=>"true", "status_Code"=>"200", "message" => "You are Registered Successfully","data"=>$CurrentData],200);
        }
        }
    }

    public function Example(Request $request)
    {
        return json_encode(["status"=>"true", "message" => "Hi Mohit","data"=>$request->tocken],200);
    }

    public function deleteUser(Request $request){
        // echo '<pre>'; print_r($request->email); die;
        $ID = $request->email;
        if($ID==""){
             return json_encode(["status"=>"false", "message" => "Please Enter Email","data"=>[]],401);
        }
        $emailCount = User::where('email',$ID)->count();
        if($emailCount >0){
        $done = User::where('email',$ID)->delete();
        return json_encode(["status"=>"true", "message" => "Deleted Successfully","data"=>$request->id],200);
        }
        else{
            return json_encode(["status"=>"false", "message" => "Email Does Not Exist","data"=>[]],401);
        }
    }

    public function updateUserPassword(Request $request){
       // echo '<pre>'; print_r($request->email); die;
        $email =$request->email;
         $password = $request->password;
        $passwordReset =$request->c_password;
        if($email==""){
             return json_encode(["status"=>"false", "message" => "Please Enter Email","data"=>[]],401);
        }
        if($request->password==""){
             return json_encode(["status"=>"false", "message" => "Please Enter Password","data"=>[]],401);
        }
        if($request->password!=$request->c_password){
             return json_encode(["status"=>"false", "message" => "Please Check Confirm New Password","data"=>[]],401);
        }
        $emailCount = User::where('email',$email)->count();
        if($emailCount >0){

         $done = User::where('email',$email)->update(["password" => Hash::make($password)]);
         return json_encode(["status"=>"true", "message" => "Password Updated Successfully","data"=>""] ,200);
        }
        else{
            return json_encode(["status"=>"false", "message" => "Email Does Not Exist","data"=>[]],401);
        }
        
    }


    public function changeStatus(Request $request){
        $access_token = $request->header('Authorization');
        // break up the string to get just the token
        
        if($access_token==""){
            return json_encode(["status"=>"false", "message" => "Token is Missing","status_Code"=>"401"],401);
        }

       // $res= User::upsert([
       //  ['id'=>1,'status' => 'Active'],
       //  ['id'=>2,'status' => 'Inactive'],
       //      ], ['id'] );

        $res = DB::statement('UPDATE users SET users.status = (CASE WHEN users.status="Inactive" THEN "Active"
            WHEN users.status="Active" THEN "Inactive" END)');
       if($res){
        return json_encode(["status_Code"=>"200", "message" => "Updated Successfully","data"=>[]],200);
        }


    }


     public function GetUserListing(Request $request){
        $tocken = $request->week_number;
        if($tocken=="" && !isset($tocken)){
             return json_encode(["status"=>"false", "message" => "Tocken Error","data"=>[]],401);
        }
        $week =  explode(',',$tocken);
       $newWeek= array_map(function($parm){
            if($parm ==0){
                return 6;
            }
            elseif($parm ==1){
                return 0;
            }
            elseif($parm ==2){
                return 1;
            }
            elseif($parm ==3){
                return 2;
            }
            elseif($parm ==4){
                return 3;
            }
            elseif($parm ==5){
                return 4;
            }
            elseif($parm ==6){
                return 5;
            }
            else{
                return ;
            }
        },$week);
       $result = User::select('users.name','users.email' ,
          DB::raw('WEEKDAY(DATE_FORMAT(users.created_at,"%Y-%m-%d")) as WeeK') )
       ->whereRaw('WEEKDAY(DATE_FORMAT(users.created_at,"%Y-%m-%d")) IN ('.implode(",",$newWeek).')')
       ->get();

       foreach($result as $key){
        if($key->WeeK ==0){
             $data['Monday'][] = array(
                "name" =>$key->name,
                "email" => $key->email
             );
        }
        elseif($key->WeeK ==1){
            $data['Tuesday'][] = array(
                "name" =>$key->name,
                "email" => $key->email
             );
        }
        elseif($key->WeeK ==2){
            $data['Wednesday'][] = array(
                "name" =>$key->name,
                "email" => $key->email
             );
        }
        elseif($key->WeeK ==3){
            $data['Thursday'][] = array(
                "name" =>$key->name,
                "email" => $key->email
             );
        }
        elseif($key->WeeK ==4){
            $data['Friday'][] = array(
                "name" =>$key->name,
                "email" => $key->email
             );
        }
        elseif($key->WeeK ==5){
            $data['Saturday'][] = array(
                "name" =>$key->name,
                "email" => $key->email
             );
        }
        elseif($key->WeeK ==6){
            $data['Sunday'][] = array(
                "name" =>$key->name,
                "email" => $key->email
             );
        }

       }
      // print_r($result->toArray()); die;
      return json_encode(["status_Code" =>"200",
                "message" =>"Result Found Success",
                 "data" =>$data
            ],200);

    }


    public function Get_Distance(Request $request){

        $access_token = $request->header('Authorization');
        
        if($access_token==""){
            return json_encode(["status"=>"false", "message" => "Token is Missing","status_Code"=>"401"],401);
        }
        $auth_header = explode('|', $access_token);
        $token = $auth_header[1];
       $finaltoken= hash('sha256', $token);
    
        $lati = $request->Destination_Latitude;
         $logit = $request->Destination_Longitude;
        if($lati=="" && !isset($lati)){
             return json_encode(["status"=>"false", "message" => "Please Enter Destination_Latitude ","data"=>[]],401);
        }

        if($logit=="" && !isset($logit)){
             return json_encode(["status"=>"false", "message" => "Please Enter Destination_Longitude","data"=>[]],401);
        }

        $result = User::leftjoin('personal_access_tokens','personal_access_tokens.tokenable_id','users.id')->select('users.name','users.email' ,
          DB::raw('111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(users.latit)) * COS(RADIANS('.$lati.')) * COS(RADIANS(users.longit - '.$logit.')) + SIN(RADIANS(users.latit)) * SIN(RADIANS('.$lati.'))))) as Distance') )
        ->where("personal_access_tokens.token",$finaltoken)
        ->first();

        if(!empty( $result)){
            return json_encode(["status_Code"=>"200", "message" => "Distance Found Successfully","data"=>["Distance" => number_format($result->Distance,2,'.','')." KM"]],200);
        }
        else{
             return json_encode(["status_Code"=>"401", "message" => "Rocord Not Found","data"=>[]],401);
        }

    }
}