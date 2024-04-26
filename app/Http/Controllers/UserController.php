<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    // --------

    


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('AppName')->plainTextToken;
            return response()->json(['user' => $user, 'access_token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
    // ----
    public function signup(Request $request)
    {
        // التحقق من صحة البيانات المرسلة
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email', // إزالة أي معرفات مستخدم مستثناة
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
        ]);
    
        // إنشاء حساب جديد
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // تشفير كلمة المرور
        ]);
    
        // حفظ الحساب الجديد في قاعدة البيانات
        $user->save();
    
        // إرجاع رسالة نجاح بعد إنشاء الحساب
        return response()->json(['message' => 'تم أنشاء الحساب بنجاح'], 201);
    }
    
}
