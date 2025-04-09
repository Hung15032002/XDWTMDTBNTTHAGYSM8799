<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Adminlogincontroller extends Controller
{
   
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator ->passes()){
            if(Auth::guard('admin')->attempt(['email'=> $request->email , 'password' => $request->password],$request->get('remeber'))){
                $admin = Auth::guard('admin')->user();
                if($admin->role == 1 ){
                    return redirect()->route('admin.dashboard');
                }  else {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','bạn không có quyền truy cập trang chủ admin!');
                }
            } else{
                return redirect()->route('admin.login')->with('error','vui lòng nhập lại tài khoản mật khẩu!');
            }
        } else{
            return redirect()->route('admin.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }
  
}
