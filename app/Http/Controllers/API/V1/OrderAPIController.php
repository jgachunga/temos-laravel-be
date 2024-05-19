<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateOrderAPIRequest;
use App\Http\Requests\API\V1\UpdateOrderAPIRequest;
use App\Models\Order;
use App\Repositories\Backend\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Invoice;
use Response;
use Auth;
use Carbon\Carbon;

/**
 * Class OrderController
 * @package App\Http\Controllers\API\V1
 */

class OrderAPIController extends AppBaseController
{
    /** @var  OrderRepository */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Order.
     * GET|HEAD /orders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
    }
    public function listOrders(Request $request)
    {
        $user = Auth::guard('api')->user();
        $orders = Invoice::with('customer', 'items.product', 'structure', 'user', 'payment_method')
        ->where('raise_order', '=', 1)
        ->where('is_approved', 0)
        ->orderByDesc('created_at')
        ->paginate(10);

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
    }
    public function customerOrders(Request $request)
    {
        $user = Auth::guard('api')->user();
        $orders = Order::where('customer_id', $user->cust_id)->with('structure', 'customer', 'items.product')->orderByDesc('created_at')->get();

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
    }
    public function repOrders(Request $request)
    {
        $from = Carbon::now()->subDays(7)->startOfDay();
        $to =  Carbon::now()->endOfDay();
        $user_id = Auth::guard('api')->user()->id;
        $orders = Invoice::with('structure', 'customer', 'items.product')
        ->where('user_id', $user_id)
        ->where('raise_order', true)
        ->where('is_approved', 0)
        ->whereBetween('loctimestamp', [$from, $to])
        ->orderByDesc('created_at')->get();

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
    }
    /**
     * Store a newly created Order in storage.
     * POST /orders
     *
     * @param CreateOrderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderAPIRequest $request)
    {
        $input = $request->json()->all();
        $order = $this->orderRepository->create($input);

        return $this->sendResponse($order->toArray(), 'Order saved successfully');
    }

    /**
     * Display the specified Order.
     * GET|HEAD /orders/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        return $this->sendResponse($order->toArray(), 'Order retrieved successfully');
    }

    /**
     * Update the specified Order in storage.
     * PUT/PATCH /orders/{id}
     *
     * @param int $id
     * @param UpdateOrderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderAPIRequest $request)
    {
        $input = $request->all();

        /** @var Order $order */
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        $order = $this->orderRepository->update($input, $id);

        return $this->sendResponse($order->toArray(), 'Order updated successfully');
    }

    /**
     * Remove the specified Order from storage.
     * DELETE /orders/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        $order->delete();

        return $this->sendResponse($id, 'Order deleted successfully');
    }
}
