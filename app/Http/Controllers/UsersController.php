<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        //不使用 Auth 中间件进行过滤
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);
        //只让未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    //
    public function index(){
        //$users = User::all();
        $users = User::paginate(5);
        return view('users.index',compact('users'));

    }
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
    //用户修改
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    //用户信息修改
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
