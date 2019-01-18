<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * 用戶操作curd
 */
class UsersController extends Controller
{
    public function __construct()
    {
        // 除了show/create/store方法，其他方法都要授权
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        // 未登录用户只允许注册
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    // 用户列表页面
    public function index()
    {
        // $users = User::all();
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    // 用户注册页面
    public function create()
    {
        return view('users.create');
    }

    // 用户详情页面
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // 注册action
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    // 用户编辑页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // 编辑action
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }
}
