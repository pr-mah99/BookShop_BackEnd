<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10); // استرجاع قيمة الحد الأقصى للسجلات من الطلب (الافتراضي 10)
        $page = $request->input('page', 1); // استرجاع رقم الصفحة من الطلب (الافتراضي 1)
    
        $orders = Order::orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
        return response()->json($orders);
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'orderType' => 'required|string|max:255',
            'items' => 'required|array', // يجب أن يكون مصفوفة
            'items.*.bookId' => 'required|numeric', // كل عنصر في المصفوفة يجب أن يحتوي على bookId
            'items.*.quantity' => 'required|numeric|min:1', // كل عنصر في المصفوفة يجب أن يحتوي على كمية صحيحة
            'location' => 'required|string|max:255',
            'payment' => 'required|string|max:255',
            'customerNotes' => 'nullable|string|max:255',
            'total' => 'required|numeric|min:0',
            'state' => 'required|boolean',
        ]);
    
        $orders = Order::create($request->all());
        return response()->json($orders, 201);
    }

    public function update(Request $request, Order $orders)
    {
        $request->validate([
            'title' => 'string|max:255',
            'author' => 'string|max:255',
            'genre' => 'string|max:255',
            'price' => 'numeric',
            'availability' => 'boolean',
        ]);
    
        $orders->update($request->all());
        return response()->json($orders, 200);
    }

    public function destroy(Order $orders)
    {
        $orders->delete();
        return response()->json(null, 204);
    }
}
