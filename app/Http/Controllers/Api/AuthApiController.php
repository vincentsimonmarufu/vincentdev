<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Mail\EmailOtpVerification;
use App\Mail\VerificationEmail;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;
use Illuminate\Support\Facades\Session;

class AuthApiController extends ResponseController
{

    /**
     * Visitor counter API
     */
    public function countVisitor(){
        $counts = Visitor::count();

        if ($counts) {         
            return response()->json(['success' => true, 'visitorcount' => '11000'+$counts, 'message' =>'Visitor count(s)']); 
        } else {
            return response()->json(['success' => false, 'message' => 'Unable to find']);
        }

    } 


    /**
     * New user registration **
     * 
     */
    public function registerNew(Request $request)
    {
        //return $request->all();        
        $input = $request->all();
        $validator = Validator::make($input, [
            'surname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
            //'phone' => ['nullable', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), '', 400);
        }

        try {
            $input['password'] = Hash::make($input['password']);
            $input['verification_token'] = Str::random(40); //Email verification token    

            DB::beginTransaction();
            // creating user
            $user = User::create($input);
            $detail = array();
            $detail['token'] = $user->createToken('Abisiniya')->plainTextToken;
            $detail['name'] = $user->name;
            $detail['email'] = $user->email;
            $detail['userID'] = $user->id;
            if ($user) {
                //$this->sendVerificationEmail($user); // verification via email 
                //$this->otpOnMobile($user->phone); // verification via phone
                $this->sendVerificationEmailOtp($user);
            }
            DB::commit();
            return $this->sendResponse($detail, 'Registered, OTP has been sent to the email.');
        } catch (\Exception $th) {
            DB::rollBack();
            //return $this->sendError($th->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal server error'], 500); 
        }
    }


    //Sending OTP on user Email *     
    private function sendVerificationEmailOtp(User $user)
    {
        $otp = $this->generateNumericOTP(4);
        $emailId = $user->email;
        User::where('email', $emailId)
            ->update(['otp' => $otp, 'otp_expires_at' => now()->addMinutes(24*60)]);
        Mail::to($user->email)->send(new EmailOtpVerification($user, $otp));
    }


    // generate unique OTP No.
    private function generateNumericOTP($n)
    {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }


    /**
     * 2 => Email verify using OTP
     * @param email, otp
     * @method POST
     * 
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'otp' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        if (!empty($user->email_verified_at)) {
            return response()->json(['success' => false, 'message' => 'User already verified'], 404);
        }        

        // Verify the OTP
        if ($request->otp === $user->otp) {

            if (Carbon::now()->gt($user->otp_expires_at)) {
                return response()->json(['success' => false, 'message' => 'OTP has expired'], 400);
            }
            
            $userDetail = User::where(['email' => $request->email])->update([
                'otp' => null,
                'otp_expires_at' => null,
                'email_verified_at' => Carbon::now()
            ]);
            if (!empty($userDetail)) {
                return response()->json(['success' => true, 'message' => 'Email verified successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Email not verified']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 400);
        }
    }
    
    
    // resend OTP API
    public function newOtpResend(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [          
            'email' => ['required', 'string', 'email', 'max:255']           
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        try {
            $user = User::where('email', $input['email'])->first();

            if ($user) {
                $this->sendVerificationEmailOtp($user);
                $msg = 'OTP has been resent successfully to the email.';
                return response()->json(['success' => true, 'message' => $msg]); 
            } else {
                return response()->json(['success' => false, 'message' => 'User not found. Unable to send OTP.']);
            }
        } catch (Exception $th) {          
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);       
        }

    }
    

    /**
     * 3 => Login API *
     * @param email, password
     * @method POST
     * 
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), '', 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // visitor count          
                $visitorIp = $request->ip();  // Get the visitor's IP address        
                $sessionId = Session::getId();// Get the current session ID        
                $existingVisitor = Visitor::where('ip_address', $visitorIp)
                    ->where('session_id', $sessionId)
                    ->first();// Check if the visitor's IP and session ID combination already exists in the database        
                if (!$existingVisitor) {
                    $url = $request->fullUrl();// If the visitor's IP and session ID combination doesn't exist, count the visit           
                    Visitor::create([
                        'ip_address' => $visitorIp,
                        'session_id' => $sessionId,
                        'url' => $url
                    ]); // Store the visitor's information in the database
                }
            // end of visitor count
            $userId = Auth::id();
            $user = User::find($userId);
            if ($user->email_verified_at == null) {
                return $this->sendError('Please verify email before login.');
            }

            $data['token'] = $user->createToken('Abisiniya')->plainTextToken;
            $data['token_type'] = 'Bearer';
            $data['name'] = $user->name;
            $data['userID'] = $userId;
            //store bearer token as named api_token            
            try {
                User::where('id', $data['userID'])->update(['api_token' => $data['token']]);
                return $this->sendResponse($data, 'Login Successfully.');
            } catch (\Exception $th) {
                return $this->sendError($th->getMessage());
            }
        } else {
            return $this->sendError('Enter correct email and password');
        }
    }


     /**
     * 3 => Login API *
     * @param email, password
     * @method POST
     * 
     */
    public function login_new(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), '', 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             // visitor count          
                $visitorIp = $request->ip();  // Get the visitor's IP address        
                $sessionId = Session::getId();// Get the current session ID        
                $existingVisitor = Visitor::where('ip_address', $visitorIp)
                    ->where('session_id', $sessionId)
                    ->first();      
                if (!$existingVisitor) {
                    $url = $request->fullUrl();          
                    Visitor::create([
                        'ip_address' => $visitorIp,
                        'session_id' => $sessionId,
                        'url' => $url
                    ]); 
                }
            // end of visitor count

            $userId = Auth::id();
            $user = User::find($userId);
            if ($user->email_verified_at == null) {
                return $this->sendError('Please verify email before login.');
            }

            $data['token'] = $user->createToken('Abisiniya')->plainTextToken;
            $data['token_type'] = 'Bearer';
            $data['name'] = $user->name;
            $data['userID'] = $userId;

            User::where('id', $data['userID'])->update(['api_token' => $data['token']]);               
            return response()->json(['success' =>true, 'data' => $data], 200);
        }

        return response()->json(['success' =>false, 'message' => 'Unauthorized'], 401);
    }


    /**
     * 4 => Email verification API for forgot password using OTP
     * @param email
     * @method POST
     * 
     */
    public function forgotPasswordEmailVerify(Request $request)
    {
        $input = $request->all();

        // Validation rules
        $validator = Validator::make($input, [
            'email' => ['required', 'email'],
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    
        try {
            // Find user by email
            $user = User::where('email', $input['email'])->first();
    
            // Check if user exists
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Email not found in database'], 404);
            }
    
            // Check if email is verified
            if (!$user->email_verified_at) {
                return response()->json(['success' => false, 'message' => 'Email is not verified. Please verify first'], 400);
            }
    
            // Generate OTP
            $otp = $this->generateNumericOTP(4); // Example function to generate OTP
    
            // Update user with new OTP and OTP expiration time
            $user->otp = $otp;
            $user->otp_expires_at = now()->addSeconds(2*60);
            $user->save();
    
            // Send OTP via email
            Mail::to($user->email)->send(new EmailOtpVerification($user, $otp));
    
            return response()->json(['success' => true, 'message' => 'OTP sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * 5 => reset password API using email and OTP
     * @param email, otp, password, password_confirmation
     * @method POST
     * 
     */
    public function forgotPasswordResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            $userEmail = $request->email;
            $user = User::where('email', $userEmail)
                ->where('otp', $request->otp)->first();

            if (empty($user)) {
                return response()->json(['success' => false, 'message' => 'Invalid or expires OTP.'], 400);
            }

            // Update user's password
            $resUpdate = User::where(['email' => $userEmail])->update([
                'password' => Hash::make($request->password),
                'otp' => null,
                'otp_expires_at' => null
            ]);
            if (!empty($resUpdate)) {
                return response()->json(['success' => true, 'message' => 'Password updated.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Not updated.'], 400);
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }


    /**
     * 6 => Logout API*
     * @param Bearer token
     * @method Method
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            //$user->currentAccessToken()->delete(); // Revoke the token that was used to authenticate the current request
            $user->tokens()->delete(); // use this to revoke all tokens (logout from all devices)
            return $this->sendResponse('', 'Logged out successfully');
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    
     /**
     * 7 => User profile 
     * @param Bearer token
     * @method GET
     * 
     */
    public function profile()
    {
        try {
            $data = User::findOrFail(Auth::id());
            $userDetail = new UserResource($data);
            //return $this->sendResponse($userDetail, 'User Detail');
            return response()->json(['status' => true, 'data' =>[$userDetail] ,'visitorCount' =>'11000'+Visitor::count()], 200);
        } catch (Exception $th) {
            //return $this->sendError($exception->getMessage());
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }


    /**
     * 8 => Update user profile
     * @param name, surname, phone, email, address, country, Bearer token
     * @method POST
     * 
     */
    public function profileUpdate(Request $request)
    {
        try {
            $data = User::findOrFail(Auth::id());
            //return $data;
            $data->name = $request->name;
            $data->surname = $request->surname;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->country = $request->country;
            $data->save();
            if ($data) {
                return response()->json(['status' => true, 'message' => 'Profile Updated'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Not Updated']);
            }
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }


    // update phone no.
    public function updateMobile(Request $request)
    {
        $oldphone = $request->input('oldphone');
        $newphone = $request->input('newphone');
        $user = User::where('phone', $oldphone)->first();
        if (!empty($user->phone)) {
            $x = User::where('phone', $oldphone)->update(['phone' => $newphone]);
            if ($x)
                return response()->json(['message' => 'Mobile number updated successfully']);
            else {
                return response()->json(['message' => 'Mobile number not updated']);
            }
        } else {
            return response()->json(['message' => 'Mobile number not exist']);
        }
    }

    // sending otp in phone
    public function otpOnMobile_xyz($mobileNo)
    {
        $otpMessage = $this->generateNumericOTP(6);
        User::where('phone', $mobileNo)
            ->update(['otp' => $otpMessage, 'otp_expires_at' => now()->addMinutes(10)]);
        //$text = 'OTP for new user registration ' . $otpMessage;
        $text = $otpMessage;
        $url = "https://2factor.in/API/R1/?module=TRANS_SMS&apikey=33a7fe47-de9e-11e9-ade6-0200cd936042&to=$mobileNo&from=insigh&templatename=insight-mobile-otp&var1=&var2=$text";
        $request = array(
            'message' => $text,
            'recipients' => array(array(
                'type' => 'mobile',
                'value' => $mobileNo
            ))
        );
        $req = json_encode($request);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        //return explode(',', $result);
        return $result;
    }


    // sending otp in phone   
    private function otpOnMobile($mobileNo)
    {
        // try {
        //     $otpMessage = $this->generateNumericOTP(6);
        //     User::where('phone', $mobileNo)
        //         ->update(['otp' => $otpMessage, 'otp_expires_at' => now()->addMinutes(10)]);
        //     $message = $otpMessage;
        //     $account_sid = env('TWILIO_SID');
        //     $auth_token = env('TWILIO_TOKEN');
        //     $twilio_number = env('TWILIO_FROM');
        //     $client = new Client($account_sid, $auth_token);
        //     $receiverNumber = '+91' . $mobileNo;
        //     $successMsg = $client->messages->create(
        //         $receiverNumber,
        //         array(
        //             'from' => $twilio_number,
        //             'body' => $message
        //         )
        //     );

        //     if (!empty($successMsg)) {
        //         return $successMsg;
        //     }
        // } catch (\Exception $exception) {
        //     return $this->sendError($exception->getMessage());
        // }
    }

    /**
     * 
     * Send email verification link to user
     */
    private function sendVerificationEmail(User $user)
    {
        // Generate the verification URL with the verification token       
        $verificationUrl = URL::to('/api/v1/email/verify', ['userid' => $user->id, 'token' => $user->verification_token]);
        //$verificationUrl = url(route('email.verify', ['userid' => $user->id, 'token' => $user->verification_token]));
        Mail::to($user->email)->send(new VerificationEmail($user, $verificationUrl));
    }


    // Verify email by user     
    public function verify($user_id, $token)
    {
        // getting userid and token from email verification link
        $userId = $user_id;
        $ver_token = $token;
        try {
            $user = User::findOrFail($userId);
            //verify user email verification token
            if ($user->email_verified_at !== null && $user->email_verified_at instanceof Carbon) {
                return $this->sendResponse('', 'Email already verified');
            }
            if ($user->verification_token == $ver_token) {
                $user->email_verified_at = Carbon::now();
                if ($user->save()) {
                    return $this->sendResponse('', 'Email verified successfully');
                } else {
                    return $this->sendError('Error in email verification');
                }
            } else {
                return $this->sendError('Invalid verification token or user');
            }
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }


    /**
     * check email verification status API
     */
    public function getEmailVerificationStatus(Request $request)
    {
        try {
            $appSideUserRequestId = $request->input('user_id');
            $user = User::findOrFail($appSideUserRequestId);
            if ($user->email_verified_at !== null && $user->email_verified_at instanceof Carbon) {
                return $this->sendResponse('', 'Email is verified');
            } else {
                return $this->sendError('Please verify email');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * verification email resend*
     * 
     */
    public function resend(Request $request)
    {
        $userEmail = $request->email;
        $user = User::where('email', $userEmail)->firstOrFail();
        // dd($user);
        if ($user->hasVerifiedEmail()) {
            return $this->sendResponse('', 'Email already verified');
        }
        if ($user) {
            // Send verification email
            $this->sendVerificationEmail($user);
        }

        return $this->sendResponse('', 'Email verification link has been resent');
    }

    // Forgot password link     
    public function forgotPasswordLink(Request $request)
    {
        //return response()->json(['name' => 'Deepak']);
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => true, 'message' => 'Reset password link sent to your email'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to send link'], 400);
        }
    }

    /**
     * Forgot password link      
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['status' => true, 'message' => 'Password reset successful'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to reset password'], 400);
        }
    }

    // New Forgot password functionality @Sakshi
    public function newReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'required_without:phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user) {
            $newPassword = $request->password;
            //update password based on email
            $user->password = Hash::make($newPassword);
            $x = $user->save();
            if ($x) {
                return response()->json(['status' => true, 'message' => 'Password reset successfully.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Password not reset'], 404);
            }
        }
    }

    /**
     * forgot password
     * verify user email using OTP
     */
    public function forgotPasswordUsingOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => $validator->errors()
                ];
                return response()->json($response, 400);
            }

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            if (!empty($user)) {
                // if email exist, then sending email
                $this->sendVerificationEmailOtp($user);

                $validator = Validator::make($request->all(), [
                    'otp' => ['required'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                if ($validator->fails()) {
                    $response = [
                        'success' => false,
                        'message' => $validator->errors()
                    ];
                    return response()->json($response, 400);
                }

                $userDetail = User::find($user->id);
                if ($userDetail->otp !== $request->otp) {
                    return response()->json(['success' => false, 'message' => 'Invalid OTP']);
                }

                User::where('email', $userDetail->email)
                    ->update(['password' => Hash::make($request->password), 'otp' => null, 'otp_expires_at' => null]);

                return response()->json(['success' => true, 'message' => 'Password reset successful.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Email is not valid']);
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * reset password api
     * using otp
     */
    public function resetPasswordUsingOTP_x(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|numeric',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        try {
            // Find the user
            $user = User::findOrFail($request->user_id);

            // Check if OTP matches and not expired
            if ($user->otp !== $request->otp || now() > $user->otp_expiry) {
                return response()->json(['success' => false, 'message' => 'Invalid OTP or expired.']);
            }

            // Update user's password
            $user->password = Hash::make($request->new_password);
            $user->otp = null; // Clear OTP fields
            $user->otp_expires_at = null;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Password reset successful.']);
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Last inserted user detail
     * 
     */
    public function users()
    {
        try {
            $users = User::orderBy('id', 'desc')->get();
            if ($users) {
                return response()->json(['status' => true, 'message' => 'list of top 10 users', 'data' => $users]);
            } else {
                return response()->json(['status' => false, 'data' => 'error']);
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
        //$users = User::orderBy('id', 'desc')->take(1)->get();
    }

    public function userDelete($email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }
}
