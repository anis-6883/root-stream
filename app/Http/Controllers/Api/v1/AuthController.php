<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordMail;
use App\Models\AppModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle a signup request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'app_id' => 'required',
            'platform' => 'nullable',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => false, 'message' => $validator->errors()->first()]);
        }
        $app_unique_id = $request->app_id;

        $app = AppModel::where('app_unique_id', $app_unique_id)->firstOrFail();
        if($request->provider == 'google' || $request->provider == 'apple' || $request->provider == 'facebook'){
            $user = User::where('email', "{$app->id}_$request->email")->where('user_type', 'user')->exists();
            if($user){
                return $this->signin($request);
            }
        }
        
        $request->merge(['email' => "{$app->id}_$request->email"]);
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:191|unique:users',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:6|confirmed',
            'device_token' => 'required',
            'provider' => 'required',
            'image' => 'nullable|image'

        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->first()]);
        }
        
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 'user';
        $user->subscription_id = 0;
        $user->expired_at = null;
        $user->device_token = $request->device_token;
        $user->provider = $request->provider;
        $user->app_id = $app->id;
        $user->status = 1;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/users/'), $ImageName);
            $user->image = 'public/uploads/images/users/' . $ImageName;
        }else{
            $user->image = $request->image ?? asset('public/default/profile.png');
        }

        $user->save();

        $user->email = $user->display_email;
        $user->subscription_name = $user->subscription->name;

        $tokenResult = $user->createToken($request->device_token)->plainTextToken;
        return response()->json([
            'status' => true,
            'access_token' => $tokenResult,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'apps', 'app_id', 'email_verified_at', 'status', 'subscription']),
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'app_id' => 'required',
            'platform' => 'nullable',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => false, 'message' => $validator->errors()->first()]);
        }

        $app_unique_id = $request->app_id;
        
        $app = AppModel::where('app_unique_id', $app_unique_id)->firstOrFail();
        $request->merge(['email' => "{$app->id}_$request->email"]);
        $validator = Validator::make($request->all(), [

            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
            'device_token' => 'required',
            'provider' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->first()]);
        }

        $user = User::where('email', $request->email)->where('user_type', 'user')->first();
        
        if(!$user || ($user->provider != 'google' && $user->provider != 'apple' && $user->provider != 'facebook'))
        {
            return $user;
            if ((!$user || !Hash::check($request->password, $user->password)) ) {
                return response()->json([
                    'status' => false,
                    'message' => 'These credentials do not match our records.',
                ]);
            }
        }

        if($request->provider == 'google' || $request->provider == 'apple' || $request->provider == 'facebook'){
            if($request->provider != $user->provider){
                return response()->json([
                    'status' => false,
                    'message' => 'These credentials do not match our recordsd.',
                ]);
            }
        }
        
        $user->tokens()->delete();

        $user->device_token = $request->device_token;

        $user->save();

        $user->email = $user->display_email;
        $user->subscription_name = $user->subscription->name;

        $tokenResult = $user->createToken($request->device_token)->plainTextToken;
        return response()->json([
            'status' => true,
            'access_token' => $tokenResult,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'apps', 'app_id', 'email_verified_at', 'status', 'subscription']),
        ]);
    }

    // Get User Info
    public function user(Request $request)
    {
        $user = $request->user();

        if($user->expired_at < date('Y-m-d')){
            $user->subscription_id = 0;
            $user->expired_at = null;
            $user->save();
        }

        $user->email = $user->display_email;
        $user->subscription_name = $user->subscription->name;

        return response()->json([
            'status' => true,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'apps', 'app_id', 'email_verified_at', 'status', 'subscription']),
        ]);
    }

    // User Info Update
    public function user_update(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',

        ]);

        if ($validator->fails()) {
            return response()->json(['result' => false, 'message' => $validator->errors()->first()]);
        }

        $user->name = $request->name;
        $user->phone = $request->phone;

        $user->save();

        $user->email = $user->display_email;
        $user->subscription_name = $user->subscription->name;
		
        return response()->json([
            'status' => true,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'apps', 'app_id', 'email_verified_at', 'status', 'subscription']),
        ]);
    }

    // Change Password
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = $request->user();

        if (Hash::check($request->old_password, $user->password)) {

            if (!Hash::check($request->password, $user->password)) {

                $user->password = Hash::make($request->password);
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Password has been changed!',
                ]);
            } else {

                return response()->json([
                    'status' => false,
                    'message' => 'New Password can not be the old password!',
                ]);
            }
        } else {

            return response()->json([
                'status' => false,
                'message' => 'Old Password not match!',
            ]);
        }
    }

    // Forget Password
    public function forget_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'app_id' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => $validator->errors()->first(),
            ]);
        }
        $app_unique_id = $request->app_id;
        $app = AppModel::where('app_unique_id', $app_unique_id)->firstOrFail();
        $request->merge(['email' => "{$app->id}_$request->email"]);
        
        $user = User::where('email', $request->email)->where('provider', 'email')->first();
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Please enter your valid email address.',
            ]);
        }

        $password = substr(rand(), 0, 6);

        $user->password = Hash::make($request->password);
        $user->save();

        $user->newPassword = $password;

        $this->send_message($user);

        return response()->json([
            'status' => true,
            'message' => 'Please check your email for your password.',
        ]);
    }

    // Send Mail
    public function send_message($user)
    {
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);

        // Timezone
        config(['app.timezone' => get_option('timezone')]);

        // Email
        config(['mail.driver' => 'smtp']);
        config(['mail.from.name' => $user->app->from_name]);
        config(['mail.from.address' => $user->app->from_mail]);
        config(['mail.host' => $user->app->smtp_host]);
        config(['mail.port' => $user->app->smtp_port]);
        config(['mail.username' => $user->app->smtp_username]);
        config(['mail.password' => $user->app->smtp_password]);
        config(['mail.encryption' => $user->app->smtp_encryption]);
        
        $mail  = new \stdClass();
        $mail->name = $user->name;
        $mail->email = $user->email;
        $mail->subject = 'Forget Password';
        $mail->message = 'Forget Password';
        $mail->user = $user;
        
        if($user->email != ''){
            try{
                Mail::to($user->display_email)->send(new ForgetPasswordMail($mail));      
                return json_encode(array('result' => true, 'message' => _lang('Your Message send sucessfully.')));
            }catch (\Exception $e) {
                return json_encode(array('result' => false, 'message' => _lang('Error Occured, Please try again !')));
            }        
        }
    }
}
