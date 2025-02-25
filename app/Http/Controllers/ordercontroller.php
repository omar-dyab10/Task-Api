<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class ordercontroller extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
    }
    public function store(Request $request)
    {

        $data = $request->validate([
            "user_id" => 'required|exists:users,id',
            'name' => 'required',
            'price' => 'required',
            'status' => 'required|in:pending,completed,declined,processing'
        ]);
        $order = Order::create($data);
        return response()->json([
            'message' => 'Order created successfully!'
        ], 201);
    }
    public function show($order)
    {
        // dd($order);
        $order = Order::find($order);
        return new OrderResource($order);
    }
    public function update(Request $request, $order)
    {
        $data = $request->validate([
            'name' => 'required|sometimes',
            'price' => 'required|sometimes',
            'status' => 'required|in:pending,completed,declined,processing|sometimes'
        ]);
        $order = Order::find($order);
        $order->update($data);
        return [new OrderResource($order), 'message' => 'Order updated successfully!'];
    }
    public function destroy(order $order) {
        $order->delete();
        return response()->json([
            'message' => 'Order deleted successfully!'
        ]);
    }
}
