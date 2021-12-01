<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ShippingTitle;
use Illuminate\Http\Request;

class ShippingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipping = ShippingTitle::all();
        return response()->json($shipping);
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
            'ship_title' => 'required'

        ]);



        $request_add = ShippingTitle::create([

            'ship_title' =>request('ship_title')

        ]);

        return $this->sendResponse($request_add, 'Shipping Titles Created Successfully');

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
        $this->validate($request, [
            'ship_title' => 'required'

        ]);

        $request_update = ShippingTitle::findOrFail($id);

        $request_update->update($request->all());


        return $this->sendResponse($request_update, 'Shipping Titles Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request_delete = ShippingTitle::findOrFail($id);

        $request_delete->delete();

        return $this->sendResponse($request_delete, 'Titles has been Deleted');
    }
}
