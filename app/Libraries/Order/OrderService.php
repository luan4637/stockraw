<?php

namespace App\Libraries\Order;

use App\Services\Order\OrderCafef;
use App\Services\Order\OrderInterface;
use App\Models\OrderModel;

class OrderService
{
    /** @var OrderInterface */
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderCafef();
    }

    /**
     * @var string $code
     * @return OrderModel[]
     */
    public function getOrders(string $code, string $date, SortOrderInterface $sortOrder): array
    {
        /** @var OrderModel[] $orders */
        $orders = $this->orderService->requestAjax($code, $date);
        $orders = array_combine(array_column($orders, 'time'), $orders);
        ksort($orders);
        /** @var OrderModel[] $sortedOrders */
        $sortedOrders = $orders;
        /** @var string */
        $sortParam = $sortOrder->getSort();
        /** @var string */
        $orderParam = $sortOrder->getOrder();
        
        usort($sortedOrders, function($order1, $order2) use ($sortParam, $orderParam) {
            $volOrder1 = $order1->$sortParam;
            $volOrder2 = $order2->$sortParam;
            if ($volOrder1 == $volOrder2) {
                return 0;
            }
            if ($orderParam == 'desc') {
                return ($volOrder1 > $volOrder2) ? -1 : 1;
            } else {
                return ($volOrder1 < $volOrder2) ? -1 : 1;
            }
        });
        $sortedOrders = array_combine(array_column($sortedOrders, 'time'), $sortedOrders);
        $times = array_keys($orders);
        foreach ($sortedOrders as $key => &$item) {
            $findIndex = array_search($key, $times);
            $prevItemOrders = null;
            if ($findIndex > 0) {
                $prevItemOrders = $orders[$times[$findIndex-1]];
            }
            if ($prevItemOrders) {
                if ($item->price > $prevItemOrders->price) {
                    $item->increase = true;
                }
                if ($item->price < $prevItemOrders->price) {
                    $item->increase = false;
                }
            }
        }

        return array_values($sortedOrders);
    }
}