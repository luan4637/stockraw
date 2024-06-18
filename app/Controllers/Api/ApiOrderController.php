<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Order\OrderService;
use CodeIgniter\Model\OrderModel;

class ApiOrderController extends BaseController
{
    /** @var OrderService */
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function index()
    {
        /** @var string $code */
        $code = $this->request->getVar('code');
        /** @var string $date */
        $date = $this->request->getVar('date');
        if (!$date || strtotime($date) > strtotime(\getWeekday()) ) {
            $date = \getWeekday();
        }
        /** @var OrderModel[] */
        $orders = $this->orderService->getOrders($code, $date, new \App\Libraries\Order\SortOrder($this->request));
        
        $this->response([
            'total' => count($orders),
            'data' => $orders
        ]);
    }
}
