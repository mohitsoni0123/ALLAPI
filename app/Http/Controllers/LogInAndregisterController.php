<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNewModeRequest;
use App\Http\Requests\UpdateNewModeRequest;
use App\Models\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Session;
class LogInAndregisterController extends Controller
{
	public function index(Request $request){  
		//  $url = 'https://api.openweathermap.org/data/2.5/weather?q=pune&appid=f00c38e0279b7bc85480c3fe775d518c&units=metric';
		// $url = 'https://erp.priyanshuventures.com/FreightTrackingAPI/api/v1/TrackConsignmentWeb?lstAWB=533500&Status=F';
		//  $url = 'http://127.0.0.1:8001/api/Example?tocken=abcds&Status=F';
   
    //       try{
    //       	 $ch = curl_init($url);
    //       $header = array();
    //       $header[] = 'Content-Type:application/json';
    //       curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    //       curl_setopt($ch, CURLOPT_VERBOSE, true);
    //       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //  echo $url; print_r($ch);  die('A');
    //       $rest = curl_exec($ch);    
		// $title = json_decode($rest,true);
    //       	if(curl_errno($ch)){
    // 			echo 'Curl error: '.curl_error($ch);
		// 	}
		// 	curl_close ($ch);  
    //      //  print_r( $title); die;
    //        }

    //       catch(Exception $e) {
    //       echo 'Error :'.	$e->getMessage();
    //       }

          // if ($rest === false)
          // {
          //   print_r('Curl error: ' . curl_error($ch));
          // }
        //   curl_close($ch);
       
           
		return view('LogIn',["title" =>'LogIn APP']);
	}

	public function logIn(Request $request){
		// echo Hash::make($request->password); die;
		//$data ="email=".$request->email."&password=".$paaaword;
		// echo print_r( ["email"=>$request->email, "password" => $paaaword ,"token" => $request->_token]); die;
		$url = 'http://127.0.0.1:8001/api/loginServe';
 
		$data = json_encode(["email"=>$request->email, "password" =>$request->password]);
		  try{
		  $ch = curl_init($url);

          $header = array();
          
           $header[] = 'Content-Type:application/json';
           // curl_setopt($ch, CURLOPT_HEADER, true);
           // header Add Extra Details Will not Nassasary to use;
          curl_setopt($ch, CURLOPT_HTTPHEADER,$header);

          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
         curl_setopt($ch, CURLOPT_VERBOSE, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
          curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
          $rest = curl_exec($ch); 
          if ($rest === false)
          {
            print_r('Curl error: ' . curl_error($ch));
          }
           curl_close($ch);
       }
        catch(Exception $e) {
          echo 'Error :'.	$e->getMessage();
          }
          if(json_decode($rest)->status=="false"){
	          Session::flash("msg",json_decode($rest));
	          return   redirect(url('logIn')); 
      	  }
      	  else{
      	  return	json_decode($rest);
      	  }


	}


	public function RegisterUser(Request $request){
		$url = 'http://127.0.0.1:8001/api/Register';
		$data = json_encode(["name"=>$request->name, "email" =>$request->email,"password"=>$request->password ,"c_password"=>$request->c_password]);
		try{
		  $ch = curl_init($url);

          $header = array();
          
           $header[] = 'Content-Type:application/json';
           // curl_setopt($ch, CURLOPT_HEADER, true);
           // header Add Extra Details Will not Nassasary to use;
          curl_setopt($ch, CURLOPT_HTTPHEADER,$header);

          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
         curl_setopt($ch, CURLOPT_VERBOSE, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
          curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
          $rest = curl_exec($ch); 
          if ($rest === false)
          {
            print_r('Curl error: ' . curl_error($ch));
          }
           curl_close($ch);
       }
        catch(Exception $e) {
          echo 'Error :'.	$e->getMessage();
          }

          return   json_decode($rest); 

	}


  public function PutPatchDataCurl(Request $request){
    // PUT METHOD -  To Effect Entire  table Fildes.
    //PATCH METHOD - To Effect Spacific Table Fileds That selected or needed to be Changed.
    //The main difference between PUT and PATCH in REST API is that PUT handles updates by replacing the entire entity, while PATCH only updates the fields that you give it. If you use the PUT method, the entire entity will get updated. In most REST APIs, this means it will overwrite any missing fields to null.
    
    if(isset($request->Put)){ //die('M');
       $url = 'http://127.0.0.1:8001/api/updateUserPassword';
       $data = json_encode(["email" =>$request->email,"password"=>$request->password ,"c_password"=>$request->c_password, '_method' =>'PUT']);
    try{
      $ch = curl_init($url);
          $header = array();
           $header[] = 'Content-Type:application/json';
          curl_setopt($ch, CURLOPT_HTTPHEADER,$header);

          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
         curl_setopt($ch, CURLOPT_VERBOSE, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
          curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
          $rest = curl_exec($ch); 
          if ($rest === false)
          {
            print_r('Curl error: ' . curl_error($ch));
          }
           curl_close($ch);
           
        }
        catch(Exception $e) {
          echo 'Error :'. $e->getMessage();
          }

          return   json_decode($rest); 
        }
        else{
          $url = 'http://127.0.0.1:8001/api/deleteUser';
          $data = json_encode(["email"=>$request->email, '_method' =>'PATCH']);
           try{
         $ch = curl_init($url);
          $header = array();
           $header[] = 'Content-Type:application/json';
          curl_setopt($ch, CURLOPT_HTTPHEADER,$header);

          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); 
         curl_setopt($ch, CURLOPT_VERBOSE, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
          curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
          $rest = curl_exec($ch); 
          if ($rest === false)
          {
            print_r('Curl error: ' . curl_error($ch));
          }
           curl_close($ch);
        }
        catch(Exception $e) {
          echo 'Error :'. $e->getMessage();
          }

          
           return   json_decode($rest); 
        }
  }

}