<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Repositories\OrderRepository;
use App\Http\Resources\Discount;
use App\Models\DiscountRule;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
	public $repository;
	public $discounts;
	public $discount;

	public function __construct(OrderRepository $orderRepository)
	{
		$this->repository = $orderRepository;
		$this->discounts  = [];
		$this->discount  = [];
	}

	public function getOrder($id)
	{
		return $this->repository->findOrFail($id);
	}

	public function calculateDiscounts($order_id)
	{
		$order = $this->getOrder($order_id);
		$discounts = DiscountRule::orderBy('priority', 'desc')->get();
		$appliableDiscounts = [];

		foreach ($discounts as $discount) {
			$discount_category_id = $discount->category_id ?? 0;
			$discount_product_id = $discount->product_id ?? 0;
			$discount_key = $discount->discount_type . "_" . $discount_category_id . "_" . $discount_product_id;
			$appliableDiscounts[$discount_key] = $discount;
		}

		$discountResponse = [
			'orderId' => $order->id,
			'discounts' => [],
			'totalDiscount' => 0,
			'discountedTotal' => 0
		];

		$orderSubTotal = $order->total;

		foreach ($order->orderItems as $product) {
			$orderCategoryItems[$product['category_id']][] = $product;
		}

		foreach ($appliableDiscounts as $key => $discount) {

			//Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanması
			if ($discount->discount_type === 'percentage') {
				if ($order->total >= $discount->rule) {
					$discountAmount = ($orderSubTotal / 100) * $discount->rule_rate;
					$orderSubTotal -= $discountAmount;

					$discountResponse['discounts'][] = [
						'discountReason' => $discount->discount_code,
						'discountAmount' => number_format($discountAmount, '2', '.', null),
						'subTotal' => number_format($orderSubTotal, '2', '.', null)
					];
				}
			}
			//2 ID'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilmesi
			else if ($discount->discount_type === 'per_unit') {
				foreach ($order->orderItems as $orderItem) {
					if (
						$orderItem->product->category_id == $discount->category_id &&
						$orderItem->quantity >= $discount->rule
					) {
						$discountAmount = $orderItem->unitPrice * $discount->rule_rate;
						$orderSubTotal -= $discountAmount;

						$discountResponse['discounts'][] = [
							'discountReason' => $discount->discount_code,
							'discountAmount' => number_format($discountAmount, '2', '.', null),
							'subTotal' => number_format($orderSubTotal, '2', '.', null)
						];
					}
				}
			} 
			//1 ID'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılması

			else if ($discount->discount_type === 'low_price_percentage') {
				$lowestItemPrice = 0;
				$sameCategoryProductCount = 0;
				foreach ($order->orderItems as $orderItem) {
					if (
						$orderItem->product->category_id == $discount->category_id
					) {
						$sameCategoryProductCount++;
						if ($lowestItemPrice == 0 || $orderItem->unitPrice < $lowestItemPrice) {
							$lowestItemPrice = $orderItem->unitPrice;
						}
					}
				}

				if ($sameCategoryProductCount >= $discount->rule) {
					$discountAmount = ($lowestItemPrice  / 100) * $discount->rule_rate;
					$orderSubTotal -= $discountAmount;

					$discountResponse['discounts'][] = [
						'discountReason' => $discount->discount_code,
						'discountAmount' => number_format($discountAmount, '2', '.', null),
						'subTotal' => number_format($orderSubTotal, '2', '.', null)
					];
				}
			}
		}

		$discountResponse['discountedTotal'] = number_format($orderSubTotal, '2', '.', null);
		$discountResponse['totalDiscount'] = number_format(($order->total - $orderSubTotal), '2', '.', null);
		return new Discount($discountResponse);
	}
}
