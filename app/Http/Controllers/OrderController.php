<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return response()->json($this->orderService->getAllOrders());
    }

    public function store(OrderRequest $request)
    {
        return response()->json($this->orderService->createOrder($request->validated()), 201);
    }

    public function show($id)
    {
        return response()->json($this->orderService->getOrderById($id));
    }

    public function update(OrderRequest $request, $id)
    {
        return response()->json($this->orderService->updateOrder($id, $request->validated()));
    }

    public function destroy($id)
    {
        return response()->json($this->orderService->deleteOrder($id), 204);
    }
}

