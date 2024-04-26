<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        Log::info('User : ' . $user);
        if ($user !== null && $user->type === 'admin') {  
             // طباعة بيانات المستخدم
             Log::info('User ID: ' . $user->id);
             Log::info('User Name: ' . $user->name);
             Log::info('User Type: ' . $user->type);
             // وما إلى ذلك، حسب الحاجة
    
             return $next($request);
             Log::info('تم السماح بالطلب');
             // return response()->json(['message' => 'Unauthorized action.'], 403); 
    
        } else {
            abort(code: 403);
        }     
    }
    
    
    // -------#2

    // public function handle(Request $request, Closure $next)
    // {
    //     $user = Auth::user();
        
    //     if (!$user || $user->type !== 'admin') {
    //         Log::info('Unauthorized action by user ID: ' . ($user ? $user->id : 'unknown'));
    //         abort(403);
    //     }
        
    //     Log::info('User ID: ' . $user->id);
    //     Log::info('User Name: ' . $user->name);
        
    //     return $next($request);
    // }

    // ------------#3

    // public function handle(Request $request, Closure $next)
    // {
    //     if ($request->user() && $request->user()->type !== 'admin') {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     return $next($request);
    // }

        // ------------#4


        // public function handle(Request $request, Closure $next)
        // {
        //     // استخراج الـ token من رأس الطلب
        //     $token = $request->header('Authorization');
            
        //     // فحص صحة الـ token
        //     if ($token) {
        //         $user = JWTAuth::authenticate($token);
                
        //         if ($user) {
        //             // طباعة بيانات المستخدم للتحقق منها
        //             dd($user);
                    
        //             // تحقق من نوع الحساب من خلال بيانات الـ token
        //             if ($user->type) {
        //                 return $next($request);
        //             }
        //         }
        //     }
            
        //     // في حالة عدم وجود أو عدم صحة الـ token، أو نوع الحساب غير المسموح به
        //     if ($request->ajax() || $request->wantsJson()) {
        //         return response('Unauthorized.', 401);
        //     } else {
        //         return redirect(route('adminLogin'));
        //     }
        // }
}