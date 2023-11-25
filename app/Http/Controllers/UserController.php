<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Registration\UserRegistrationService;
use App\Http\Services\Utility\ResponseUtility;
use Validator;

class UserController extends Controller
{
    

    public function CreateUsers(Request $request)
    {   

        $payload = $request->all();
        $userRegistrationService = new UserRegistrationService();

        $firstNameRules   = ['first_name' => 'required'];
        $lastNamesRules   = ['last_name'  => 'required'];
        $emailRules       = ['email'      => 'required|email'];
        $passwordRules    = ['password'   => 'required'];
        $phoneNumberRules = ['phone_number' => 'required'];
        $genderRules      = ['gender' => 'required'];
        $ageRules         = ['age'      => 'required'];
        $aadharRule       = ['aadhar' =>'required|numeric'];


        //first_name validation...
        $validFirstName = Validator::make($request->all(), $firstNameRules);
        if ($validFirstName->fails()) {
            return ResponseUtility::respondWithError(4001, null);
        }

        //last_name validation...
        $validLastName = Validator::make($request->all(), $lastNamesRules);
        if ($validLastName->fails()) {
            return ResponseUtility::respondWithError(4002, null);
        }

        //email validation...
        $validEmail = Validator::make($request->all(), $emailRules);
        if ($validEmail->fails()) {
            return ResponseUtility::respondWithError(4003, null);
        }
        //password validation...
        $validPassword = Validator::make($request->all(), $passwordRules);
        if ($validPassword->fails()) {
            return ResponseUtility::respondWithError(4004, null);
        }

        //phone number validation...
        $validPhoneNumber= Validator::make($request->all(), $phoneNumberRules);
        if ($validPhoneNumber->fails()) {
            return ResponseUtility::respondWithError(4005, null);
        }

        //Gender validation...
        $validGender= Validator::make($request->all(), $genderRules);
        if ($validGender->fails()) {
            return ResponseUtility::respondWithError(4006, null);
        }

        //Age validation..
        $validAge = Validator::make($request->all(), $ageRules);
        if ($validAge->fails()){
            return ResponseUtility::respondWithError(4007,null);
        }

        //Aadhar validation..
        $validAadhar = Validator::make($request->all(), $aadharRule);
        if ($validAadhar->fails()){
            return ResponseUtility::respondWithError(4008,null);
        }

        //Dynamic validations...
        $validEmailCount = $userRegistrationService->checkEmailExists($payload['email']);
        if($validEmailCount > 0){
           return ResponseUtility::respondWithError(4009, array("email" => $payload['email']));
        }
        
        $payload['ip_address'] = $userRegistrationService->getIp();
        $data =  $userRegistrationService->CreateUsers($payload);
        //return ResponseUtility::respondWithSuccess(4501, $data);
        
        //GENERATE users session-token...
        $sessionData = $userRegistrationService->userLogin($payload);

        return $sessionData;
        return ResponseUtility::respondWithSuccess(4501, array("session_token" => $sessionData['session_token']));


    }

    public function loginAccount(Request $request) 
    {
        $payload = $request->all();

        $emailRules    = ['email' => 'required|email'];
        $passwordRules = ['password' => 'required'];

        //Email validation...
        $validEmail = Validator::make($request->all(), $emailRules);
        if ($validEmail->fails()) {
            return ResponseUtility::respondWithError(4003, null);
        }
        //Password validation...
        $validPassword = Validator::make($request->all(), $passwordRules);
        if ($validPassword->fails()) {
            return ResponseUtility::respondWithError(4004, null);
        }

        $userRegistrationService = new UserRegistrationService();
        $payload['ip_address'] = $userRegistrationService->getIp();

        $userData = $userRegistrationService->userLogin($payload); //return "kskskns";
        if($userData == ""){
            return ResponseUtility::respondWithError(4010, null);
        }

       return ResponseUtility::respondWithSuccess(4502, array('session_token' => $userData['session_token'], 
                 'user_data' => $userData['user_data']['data']));
    }

    public function forgotPassword(Request $request) 
    {
        $payload = $request->all();
        $emailRules = ['email' => 'required'];
        $phoneNumberRules = ['phone_number' => 'required'];



        //Email id validation...
        $validEmailID = Validator::make($request->all(), $emailRules);
        if ($validEmailID->fails()) {
            return ResponseUtility::respondWithError(8501, null);
        }

        //phone Validation..
        $validPhoneNumber =  Validator::make($request->all(), $phoneNumberRules);
        if ($validPhoneNumber->fails()) {
            return ResponseUtility::respondWithError(4005, null);
        }

        $UserRegistrationService = new UserRegistrationService();

        $forgotPasswordLink = $UserRegistrationService->forgotPassword($payload);
        if($forgotPasswordLink == 1)
        {
            return ResponseUtility::respondWithSuccess(8002, null);         
        }else
        {
            return ResponseUtility::respondWithError(8501, null);
        }        
    }

}
