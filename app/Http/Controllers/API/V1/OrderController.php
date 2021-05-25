<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =Order::with('orderDetails')->latest()->paginate(10);

        return response()->json($data);
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'payment_method' => 'required',
            'shipping_title' => 'required',
            'shipping_cost' => 'required',
            'user' => 'required',
            'created_way' => 'required',
            'status' => 'required',
        ]);



        $order =Order::create([

            'name' =>request('name'),
            'address' =>request('address'),
            'phone' =>request('phone'),
            'payment_method' =>request('payment_method'),
            'shipping_title' =>request('shipping_title'),
            'shipping_cost' =>request('shipping_cost'),
            'user' =>request('user'),
            'created_way' =>request('created_way'),
            'status' =>request('status'),
            'discount' =>request('discount'),
            'discount_percent' =>request('discount_percent')

        ]);



        if(!empty($order->id)){
            $data =$request->all();

            foreach ($data['product_id'] as $key => $val) {

                if (!empty($val)) {
                    //Prevent Duplicate Product Check

                    $skuCount = OrderDetail::where('product_id', $val)->where('order_id',$order->id)->count();

                    if ($skuCount > 0) {
                        return response('product already added');
                    }


                }

                $order_detail= new OrderDetail();
                $order_detail->order_id = $order->id ;
                $order_detail->product_id = $val;
                $order_detail->product_name = $data['product_name'][$key];
                $order_detail->sku = $data['sku'][$key];
                $order_detail->variation_id = $data['variation_id'][$key];
                $order_detail->quantity = $data['quantity'][$key];
                $order_detail->price = $data['price'][$key];
                $order_detail->save();

            }

        }else{
            return response('error');
        }

        return response($order);
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
        $order =Order::findOrFail($id);

        $order->update($request->all());

        return response($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
