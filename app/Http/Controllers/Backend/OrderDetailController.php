<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\OrderDetailDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreateOrderDetailRequest;
use App\Http\Requests\Backend\UpdateOrderDetailRequest;
use App\Repositories\Backend\OrderDetailRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class OrderDetailController extends AppBaseController
{
    /** @var  OrderDetailRepository */
    private $orderDetailRepository;

    public function __construct(OrderDetailRepository $orderDetailRepo)
    {
        $this->orderDetailRepository = $orderDetailRepo;
    }

    /**
     * Display a listing of the OrderDetail.
     *
     * @param OrderDetailDataTable $orderDetailDataTable
     * @return Response
     */
    public function index(OrderDetailDataTable $orderDetailDataTable)
    {
        return $orderDetailDataTable->render('order_details.index');
    }

    /**
     * Show the form for creating a new OrderDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('order_details.create');
    }

    /**
     * Store a newly created OrderDetail in storage.
     *
     * @param CreateOrderDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderDetailRequest $request)
    {
        $input = $request->all();

        $orderDetail = $this->orderDetailRepository->create($input);

        Flash::success('Order Detail saved successfully.');

        return redirect(route('orderDetails.index'));
    }

    /**
     * Display the specified OrderDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $orderDetail = $this->orderDetailRepository->find($id);

        if (empty($orderDetail)) {
            Flash::error('Order Detail not found');

            return redirect(route('orderDetails.index'));
        }

        return view('order_details.show')->with('orderDetail', $orderDetail);
    }

    /**
     * Show the form for editing the specified OrderDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $orderDetail = $this->orderDetailRepository->find($id);

        if (empty($orderDetail)) {
            Flash::error('Order Detail not found');

            return redirect(route('orderDetails.index'));
        }

        return view('order_details.edit')->with('orderDetail', $orderDetail);
    }

    /**
     * Update the specified OrderDetail in storage.
     *
     * @param  int              $id
     * @param UpdateOrderDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderDetailRequest $request)
    {
        $orderDetail = $this->orderDetailRepository->find($id);

        if (empty($orderDetail)) {
            Flash::error('Order Detail not found');

            return redirect(route('orderDetails.index'));
        }

        $orderDetail = $this->orderDetailRepository->update($request->all(), $id);

        Flash::success('Order Detail updated successfully.');

        return redirect(route('orderDetails.index'));
    }

    /**
     * Remove the specified OrderDetail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $orderDetail = $this->orderDetailRepository->find($id);

        if (empty($orderDetail)) {
            Flash::error('Order Detail not found');

            return redirect(route('orderDetails.index'));
        }

        $this->orderDetailRepository->delete($id);

        Flash::success('Order Detail deleted successfully.');

        return redirect(route('orderDetails.index'));
    }
}
