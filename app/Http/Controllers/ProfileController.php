<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = User::find(Auth::User()->id);
        if(! $request->ajax()){
            return view('profile.show', compact('profile'));
        }else{
            return view('profile.modal.show', compact('profile'));
        }
    }


    public function edit(Request $request)
    {
        $profile = User::find(Auth::User()->id);
        if(! $request->ajax()){
            return view('profile.edit', compact('profile'));
        }else{
            return view('profile.modal.edit', compact('profile'));
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'email' => [
                'required',
                Rule::unique('users')->ignore(Auth::User()->id),
            ],
            'image' => 'nullable|image|max:5120',
        ]);
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        $profile = User::find(Auth::User()->id);
        $profile->name = $request->name;
        $profile->email = $request->email;
        if ($request->hasFile('profile')){
            $image = $request->file('profile');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/users/'), $ImageName);
            $profile->profile = 'users/' . $ImageName;
        }
        $profile->save();

        if(! $request->ajax()){
            return redirect('dashboard')->with('success', _lang('Information has been updated'));
        }else{
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Information has been updated sucessfully!')]);
        }
    }

    /**
     * Show the form for password_change the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password_change(Request $request)
    {
        if(! $request->ajax()){
            return view('profile.password');
        }else{
            return view('profile.modal.password');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        $profile = User::find(Auth::User()->id);
        if(Hash::check($request->oldpassword, $profile->password)){
            $profile->password = Hash::make($request->password);
            $profile->save();
        }else{
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=> [_lang('Old Password not match')]]);
            }else{
                return back()->with('error', _lang('Old Password not match'));
            } 
        }
        if(! $request->ajax()){
            return back()->with('success', _lang('Password has been changed'));
        }else{
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Password has been changed sucessfully!')]);
        }
    }
}
