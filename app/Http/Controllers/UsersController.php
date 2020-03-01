<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //
    public function create() {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //處理表單
    public function store(Request $request)
    {
        //效驗表單提交的信息
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        //效驗通過後獲取用戶信息
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //注册成功后直接验证登录
        Auth::login($user);
        //用戶註冊成功提示
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        //重定向到用戶頁面
        return redirect()->route('users.show', [$user]);
    }
}
