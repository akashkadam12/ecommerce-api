<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Utility\PostmarkService;

class UserModel extends Model
{
    use HasFactory;

    public static function CreateUsers($userData) 
    {
         try {
            $lastInsertedID = DB::table('tbl_usr')->insertGetId($userData);
            Log::info("User registered successfully. [" . $userData['usr_email'] . ": " . json_encode($userData) ."]");

            return $lastInsertedID;
        } catch (Exception $e) {
            Log::info("Got exception in create user " . __METHOD__ . " " . PHP_EOL . $e->getMessage());
        }
    }
    
    public static function checkEmailExists($email) 
    {
        try {
            $count = DB::table('tbl_usr')
                    ->where('usr_email', $email)
                    ->count();
            if ($count > 0) {
                Log::info("User email is already exists. [" . $email ."]");
            }
            return $count;
        } catch (Exception $e) {
            Log::info("Got exception in checkEmailExists " . __METHOD__ . " " . PHP_EOL . $e->getMessage());
        }
    }

    public static function checkUserCredentials($payload, $pass)
    {   
        try {
            $userData = DB::table('tbl_usr')
                    ->select('usr_password', 'usr_id')
                    ->where('usr_email', $payload['email'])
                    ->first();

            $returnData = array();
            if (isset($userData) && !empty($userData)) 
            {
                $stored_hash = $userData->usr_password;
                $usr_id = $userData->usr_id;

                if (password_verify($pass, $stored_hash))
                {
                    $query = DB::table('tbl_usr')
                        ->select('usr_id', 'usr_email', 'usr_first_name','usr_gender','active_status')
                        ->where('usr_email', $payload['email'])
                        ->where('usr_id', $usr_id)
                        ->first();

                    $returnData['data'] = (array) $query;
                }
            }
            return $returnData;
        } catch (Exception $e) {
            Log::info("LeaderboardModel: Got exception in checkUserCredentials function ".PHP_EOL.$e->getMessage());
        }
    }

  

    public static function createUserSession($insertData) 
    {
        try {
            $lastInsertedID = DB::table('tbl_session_tokens')->insertGetId($insertData);
            Log::info("User login successfully. [" . $insertData['usr_email'] . "]");
            return $lastInsertedID;
        } catch (Exception $e) {
            Log::info("Got exception in create user session " . __METHOD__ . " " . PHP_EOL . $e->getMessage());
        }
    }



    public static function updateLastLoginDetails($userID, $ipAddress) 
    {
        try {
            $updateData = DB::table('tbl_usr')
                    ->where('usr_id', $userID)
                    ->update(array('usr_last_ip' => $ipAddress, 'usr_last_login' => time()));
            return $updateData;
        } catch (Exception $e) {
            Log::info("Got exception in update last login details " . __METHOD__ . " " . PHP_EOL . $e->getMessage());
        }
    }

    public static function forgotPassword($payload)
    {
        try {
                $postmark = new PostmarkService();  
                $query =  DB::table('users')
                             ->select('email','id')
                             ->where(array("email" => $payload['email']))
                             ->first();
                if($query == "")
                {
                    return 0;
                }

                $usrId   = $query->id;
                $rootUrl = getenv('ROOT_URL');

                $token = md5(rand().microtime());

                $insertData['usr_id']    = $usrId;
                $insertData['email']     = $payload['email'];
                $insertData['token']     = $token;
                $insertData['date_created'] = time();

                $lastInsertedID = DB::table('usr_forgot_password')->insertGetId($insertData);

                $reset_link = $rootUrl.'/auth/reset-password/'.$payload['email'].'/'.$token;

                $reset_content = '<p>Dear Coreg User, <br /><br />'.
                'You have requested a reset for your Coreg user account password.'.
                '<br><br>Just click on the link below or copy and paste it into your web browser <br> <a href="'.$reset_link.'">'.$reset_link.'</a>'. 
                '<br><br>If you did not make or authorize this request, please reach out to <a href="mailto:support@betwext.com">support@betwext.com</a>.<br>'.
                '</p> <br /><p>Thanks,<br />Coreg Support<br />';

                $postmark->to($payload['email']);
                $postmark->subject('Reset Password Instructions');
                $postmark->message_html($reset_content);  
                $postmark->send();

                Log::info("Send email: [" . $payload['email'] . "] for forgotPassword password.");
                return 1;     
            } catch (Exception $e) {
                Log::info("LeaderboardModel: Got exception in getLeaderboardData function ".PHP_EOL.$e->getMessage());
            }         
    }


}
