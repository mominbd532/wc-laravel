<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $order_details = OrderDetail::all();

       return response()->json($order_details);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'order_id' => 'required',
            'product_id' => 'required',
            'product_name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $orderDetails = OrderDetail::create([
            'order_id' =>request('order_id'),
            'product_id' =>request('product_id'),
            'sku' =>request('sku'),
            'product_name' =>request('product_name'),
            'quantity' =>request('quantity'),
            'price' =>request('price'),
            'variation_id' =>request('variation_id'),
        ]);

        return response($orderDetails);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orderDetails =OrderDetail::findOrFail($id);

        $orderDetails->update($request->all());

        return response($orderDetails);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $orderDetails = OrderDetail::findOrFail($id);

        $orderDetails->delete();

        return response($orderDetails);
    }
}
