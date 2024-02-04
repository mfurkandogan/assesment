<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\DiscountRule;
use App\Models\Product;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Resources\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $repository;
    public $productRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->repository = $orderRepository;
        $this->productRepository = $productRepository;

    }

    public function index()
    {
        return Order::collection($this->repository->all());
    }

    public function store(OrderRequest $request)
    {
        $data = $request->validated();

        $orderItem = [];
        $orderTotal = 0;
        foreach ($data['items'] as $key => $value) {
            $getProductStock = $this->productRepository->find($value['product_id']);
            
            if($getProductStock->quantity < $value['quantity']){
                return response([
                    'message' => "İlgili ürün için yeterli stok bulunmamaktadır."
                ],400);
            }

            $getProductData = $this->productRepository->find($value['product_id']);
            $total = $value['quantity'] * $getProductData->price;
            $orderTotal += $total;
            $orderItem[] = [
                "itemData" => $value, 
                "productData" => $getProductData, 
                "total" => $total,
                "quantity" => $value['quantity']
            ];
        }

        $data["total"] = $orderTotal;

        $order = $this->repository->create($data);

        foreach($orderItem as $item){
            $order->orderItems()->create([
                'product_id' => $item['productData']['id'],
                'quantity' => $item['itemData']['quantity'],
                'unitPrice' => $item['productData']['price'],
                'total' => $item['total']
            ]);

            // Stock update
            $newStockQuantity = $getProductStock->quantity-$value['quantity'];
            $this->productRepository->update($newStockQuantity, $item['productData']['id']);
        }

        return Order::collection($this->repository->searchOrder($order->id));
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

}
