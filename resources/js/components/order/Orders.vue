<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-9">
                    <form class="form-inline">
                        <label class="mr-2">From Date: </label>
                        <datepicker v-model="start_date" name="start_date"  :bootstrap-styling="true" class="mr-2" :disabledDates="state.disabledDates"></datepicker>


                        <label class="mr-2">To Date: </label>
                        <datepicker v-model="end_date" name="end_date"  :bootstrap-styling="true"  class="mr-2" :disabledDates="state.disabledDates"></datepicker>

                        <button type="button" class="btn btn-primary" @click="dateWiseOrder">Submit</button>
                    </form>


                </div>
                <div class="col-3">
                    <!-- SEARCH FORM -->
                    <form class="form-inline ml-3">
                        <div class="input-group">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="tableSearch" >
                        </div>
                            <div class="input-group-append">
                                <button class="btn btn-navbar" disabled>
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                    </form>
                </div>
            </div>
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Local Order List</h3>

                            <div class="card-tools">

                                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                                    <i class="fa fa-plus-square"></i>
                                    Add New
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body  p-0">
                            <div class="mytable">
                                <table class="table table-hover">
                                    <thead style="position: sticky; top: 0" class="thead-dark">
                                    <tr>

                                        <th class="header"><input type="checkbox"></th>
                                        <th class="header">Id</th>
                                        <th class="header">Date <button class="btn btn-sm float-right" @click="shoringOrders('date')"><i class="fa" :class="ascending && shortingType=='date' ? 'fa-chevron-up' : 'fa-chevron-down'"></i></button></th>
                                        <th class="header">Name <button class="btn btn-sm float-right" @click="shoringOrders('name')"><i class="fa" :class="ascending && shortingType=='name' ? 'fa-chevron-up' : 'fa-chevron-down'"></i></button></th>
                                        <th class="header">Address <button class="btn btn-sm float-right"  @click="shoringOrders('address')"><i class="fa" :class="ascending && shortingType=='address' ? 'fa-chevron-up' : 'fa-chevron-down'"></i></button></th>
                                        <th class="header">Phone <button class="btn btn-sm float-right"><i class="fa fa-chevron-down"></i></button></th>
                                        <th class="header">Products </th>
                                        <th class="header">Pay Method <button class="btn btn-sm float-right"  @click="shoringOrders('payment_method')"><i class="fa" :class="ascending && shortingType=='payment_method' ? 'fa-chevron-up' : 'fa-chevron-down'"></i></button></th>
                                        <th class="header">Sub Total </th>
                                        <th class="header">Fixed Disc </th>
                                        <th class="header">% Discount </th>
                                        <th class="header">Shipping Titles <button class="btn btn-sm float-right" @click="shoringOrders('shipping_title')"><i class="fa" :class="ascending && shortingType=='shipping_title' ? 'fa-chevron-up' : 'fa-chevron-down'"></i></button></th>
                                        <th class="header">Shipping Cost </th>
                                        <th class="header">Grand Total </th>
                                        <th class="header">Order Status <button class="btn btn-sm float-right" @click="shoringOrders('status')"><i class="fa" :class="ascending && shortingType=='status' ? 'fa-chevron-up' : 'fa-chevron-down'"></i></button></th>
                                        <th class="header">Notes</th>
                                        <th class="header">User</th>
                                        <th class="header">Txn Number</th>
                                        <th class="header">Txn Id</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="order in filterOrders">
                                        <td><input type="checkbox"></td>
                                        <td>{{order.id}}</td>
                                        <td >
                                            <p style="display: flex; width: 160px"> {{diniDateTime(order.created_at)}}</p>
                                        </td>
                                        <td >
                                        <textarea  name="name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'" style="width: 200px;">{{order.name}}</textarea>
                                            <has-error :form="form" field="name" ></has-error>
                                        </td>
                                        <td >
                                        <textarea  name="address"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('address') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'" style="width: 200px;">{{order.address}}</textarea>

                                            <has-error :form="form" field="address" ></has-error>
                                        </td>
                                        <td >
                                            <input :value="order.phone" type="text" name="phone"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'" style="width: 120px;">
                                            <has-error :form="form" field="phone" ></has-error>

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" @click="newModal1(order.id)">Products</button>
                                        </td>
                                        <td >
                                            <select class="form-control" name="payment_method" @change="updateOrder($event, order.id)"  :disabled="order.status == 'pre-cancel'" style="width: 160px;">
                                                <option
                                                    v-for="(payment,index) in paymentMethods" :key="index"
                                                    :value="payment.method" :selected="order.payment_method == payment.method">{{payment.pay_name}}</option>
                                            </select>
                                            <has-error :form="form" field="payment_method"></has-error>
                                        </td>


                                        <td style="display: table; vertical-align: middle !important;">{{subTotalList(order.order_details)}} TK</td>
                                        <td>
                                            <input :value="order.discount" type="number" name="discount"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('discount') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'" style="width: 100px;">
                                            <has-error :form="form" field="discount" ></has-error>
                                        </td>
                                        <td>
                                            <input :value="order.discount_percent" type="number" name="discount_percent"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('discount_percent') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'" style="width: 100px;">
                                            <has-error :form="form" field="discount_percent" ></has-error>
                                        </td>
                                        <td >
                                            <select class="form-control" name="shipping_title" @change="updateOrder($event, order.id)"  :disabled="order.status == 'pre-cancel'" style="width: 200px;">
                                                <option
                                                    v-for="(ship,index) in shippings" :key="index"
                                                    :value="ship.ship_title" :selected="order.shipping_title == ship.ship_title">{{ship.ship_title}}</option>
                                            </select>
                                            <has-error :form="form" field="shipping_title"></has-error>
                                        </td>
                                        <td>
                                            <input :value="order.shipping_cost" type="number" name="shipping_cost"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('shipping_cost') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'" style="width: 100px;">
                                            <has-error :form="form" field="shipping_cost" ></has-error>
                                        </td>

                                        <td style="display: table; vertical-align: middle !important;">{{grandTotalList(order)}} TK</td>

                                        <td>
                                            <select  class="form-control" name="status" @change="postOrder($event,order.id)" style="width: 200px;">
                                                <option value="" selected> Please Select a option</option>
                                                <option v-if="order.status == 'new'" value="confirm" >Confirm</option>
                                                <option v-if="order.status == 'new'" value="pre-cancel" >Pre-Cancel</option>
                                                <option v-if="order.status == 'pre-cancel'" value="un-cancel">Un-Cancel</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea type="text" name="note"
                                                      class="form-control" :class="{ 'is-invalid': form.errors.has('note') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'"  style="width: 200px;">{{order.note}}</textarea>
                                            <has-error :form="form" field="note" ></has-error>
                                        </td>
                                        <td><p style="display: flex; width: 150px;">{{order.user}}</p></td>
                                        <td>
                                            <input :value="order.txn_num" type="text" name="txn_num"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('txn_num') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'">
                                            <has-error :form="form" field="txn_num" ></has-error>
                                        </td>
                                        <td>
                                            <input :value="order.txn_id" type="text" name="txn_id"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('txn_id') }"  @change="updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'">
                                            <has-error :form="form" field="txn_id" ></has-error>
                                        </td>

                                        <!-- Modal -->
                                        <div class="modal fade" :id="`products${order.id}`" tabindex="-1" role="dialog" aria-labelledby="editProduct" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Products List</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <input type="checkbox" id="checkbox1" v-model="checked">
                                                                <label for="checkbox1">SKU Search</label>
                                                            </div>
                                                            <div class="col-5">

                                                                <label for="select1" class="col-8 control-label">
                                                                    Please Add Products
                                                                </label>
                                                                <v-select v-if="!checked" label="name" :filterable="false" :options="filterOptions" @search="onSearch" v-model="result1" @input="variationLoad">
                                                                    <template slot="no-options">
                                                                        type to search by name..
                                                                    </template>
                                                                    <template slot="option" slot-scope="option">
                                                                        <div class="d-center">

                                                                            {{ option.name}}- {{option.sku}}
                                                                        </div>
                                                                    </template>
                                                                    <template slot="selected-option" slot-scope="option" >
                                                                        <div class="selected d-center">

                                                                            {{ option.name }} - {{option.sku}}
                                                                        </div>
                                                                    </template>
                                                                </v-select>

                                                                <v-select v-if="checked" label="name" :filterable="false" :options="filterOptions" @search="onSearch1" v-model="result1" @input="variationLoad">
                                                                    <template slot="no-options">
                                                                        type to search by sku..
                                                                    </template>
                                                                    <template slot="option" slot-scope="option">
                                                                        <div class="d-center">

                                                                            {{ option.name}}- {{option.sku}}
                                                                        </div>
                                                                    </template>
                                                                    <template slot="selected-option" slot-scope="option" >
                                                                        <div class="selected d-center">

                                                                            {{ option.name }} - {{option.sku}}
                                                                        </div>
                                                                    </template>
                                                                </v-select>

                                                                <label v-if="variationSelect" for="select1" class="col-8 control-label">
                                                                    Please Select Variation
                                                                </label>

                                                                <select v-if="variationSelect" v-model="variation_info" @change="changeProductName($event)" style="width: 100%; margin-bottom: 10px">
                                                                    <option v-if="variation.stock_status = 'instock'" v-for="(variation,index) in options2" v-bind:value="{id: variation.id, name: variation.name, sku: variation.sku }">
                                                                        {{variation.name}} - ({{variation.sku}})
                                                                    </option>
                                                                </select>

                                                            </div>
                                                            <div class="col-3">
                                                                <label>Quantity</label>
                                                                <input v-model="addQuantity" type="number" name="quantity"
                                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                                                                <has-error :form="form" field="quantity"></has-error>
                                                            </div>
                                                            <div class="col-2">
                                                                <button type="button" class="btn btn-success mt-4" @click="addProductEdit(order.id)" :disabled="order.status == 'pre-cancel'" >
                                                                    <i class="fas fa-plus"></i>
                                                                </button>


                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Name</th>
                                                                        <th scope="col">SKU</th>
                                                                        <th scope="col">Price</th>
                                                                        <th scope="col">Quantity</th>
                                                                        <th scope="col">Total</th>
                                                                        <th scope="col">Action</th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                    <tr v-for="(detail,index) in order.order_details" :key="index">
                                                                        <th scope="row">{{index+1}}</th>
                                                                        <td>{{detail.product_name}}</td>
                                                                        <td>{{detail.sku}}</td>
                                                                        <td>
                                                                            {{detail.price}}
                                                                        </td>
                                                                        <td>
                                                                            <input :value="detail.quantity" type="number" name="quantity"
                                                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }"  @change="updateOrderDetails($event, detail.id)" :readonly="order.status == 'pre-cancel'">
                                                                            <has-error :form="form" field="quantity" ></has-error>
                                                                        </td>
                                                                        <td>
                                                                            {{detail.price * detail.quantity}}
                                                                        </td>
                                                                        <td><button type="button" class="btn btn-danger" @click="deleteProduct(detail.id)" :disabled="order.status == 'pre-cancel'" >
                                                                            <i class="fas fa-minus"></i>
                                                                        </button>
                                                                        </td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>


                                    </tr>

                                    <tr v-if="filterOrders && filterOrders.length < 1">
                                        <td colspan="19">
                                            <div style="text-align: center;"><p>No data found</p></div>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <label for="cars">Per page:</label>

                                    <select v-model="per_page" @change="changePagination">
                                        <option v-for="pages in select_per_pages" >{{pages}}</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <pagination :data="orders" @pagination-change-page="getResults" class="float-right"></pagination>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode">Create New order</h5>
                            <h5 class="modal-title" v-show="editmode">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="createOrder()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Name</label>
                                            <input v-model="form.name" type="text" name="name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                        <div class="col-4">
                                            <label>Address</label>
                                            <input v-model="form.address" type="text" name="address"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                                            <has-error :form="form" field="address"></has-error>
                                        </div>
                                        <div class="col-4">
                                            <label>Phone</label>
                                            <input v-model="form.phone" type="text" name="phone"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                            <has-error :form="form" field="phone"></has-error>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>Payment Method</label>
                                            <select class="form-control" v-model="form.payment_method">
                                                <option
                                                    v-for="(payment,index) in paymentMethods" :key="index"
                                                    :value="payment.method" :selected="index == 0">{{payment.pay_name}}</option>
                                            </select>
                                            <has-error :form="form" field="payment_method"></has-error>
                                        </div>
                                        <div class="col-3">
                                            <label>Shipping Title</label>
                                            <select class="form-control" v-model="form.shipping_title">
                                                <option
                                                    v-for="(ship,index) in shippings" :key="index"
                                                    :value="ship.ship_title" :selected="index == 0">{{ship.ship_title}}</option>
                                            </select>
                                            <has-error :form="form" field="shipping_title"></has-error>
                                        </div>
                                        <div class="col-2">
                                            <label>Shipping Cost</label>
                                            <input v-model="form.shipping_cost" type="number" name="shipping_cost"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('shipping_cost') }">
                                            <has-error :form="form" field="shipping_cost"></has-error>

                                        </div>
                                        <div class="col-2">

                                            <label>Fixed Discount</label>
                                            <input v-model="form.discount" type="number" name="discount"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('discount') }">
                                            <has-error :form="form" field="discount"></has-error>
                                        </div>
                                        <div class="col-2">

                                            <label>Percent Discount</label>
                                            <input v-model="form.discount_percent" type="number" name="discount_percent"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('discount_percent') }">
                                            <has-error :form="form" field="discount_percent"></has-error>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <textarea v-model="form.note" placeholder="Notes here..." style="min-width: 100%;"></textarea>
                                    <has-error :form="form" field="shipping_cost"></has-error>
                                </div>



                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-2">
                                            <input type="checkbox" id="checkbox" v-model="checked">
                                            <label for="checkbox">SKU Search</label>
                                        </div>
                                        <div class="col-5">

                                            <label for="select1" class="col-8 control-label">
                                                Please Add Products
                                            </label>
                                            <v-select v-if="!checked" label="name" :filterable="false" :options="filterOptions" @search="onSearch" v-model="result1" @input="variationLoad">
                                                <template slot="no-options">
                                                    type to search by name..
                                                </template>
                                                <template slot="option" slot-scope="option">
                                                    <div class="d-center">

                                                        {{ option.name}}- {{option.sku}}
                                                    </div>
                                                </template>

                                            </v-select>


                                            <v-select v-if="checked" label="name" :filterable="false" :options="filterOptions" @search="onSearch1" v-model="result1" @input="variationLoad">
                                                <template slot="no-options">
                                                    type to search by sku..
                                                </template>
                                                <template slot="option" slot-scope="option">
                                                    <div class="d-center">

                                                        {{ option.name}}- {{option.sku}}
                                                    </div>
                                                </template>

                                            </v-select>

                                            <label v-if="variationSelect" for="select1" class="col-8 control-label">
                                                Please Select Variation
                                            </label>

                                            <select v-if="variationSelect" v-model="variation_info" @change="changeProductName($event)" style="width: 100%; margin-bottom: 10px">
                                                <option v-if="variation.stock_status = 'instock'" v-for="(variation,index) in options2" v-bind:value="{id: variation.id, name: variation.name, sku: variation.sku }">{{variation.name}} - {{variation.sku}}</option>
                                            </select>

                                        </div>
                                        <div class="col-3">
                                            <label>Quantity</label>
                                            <input v-model="addQuantity" type="number" name="quantity"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                                            <has-error :form="form" field="quantity"></has-error>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-success mt-4" @click="addProduct()">
                                                <i class="fas fa-plus"></i>
                                            </button>


                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr v-for="pname,index in form.product_id" :key="index">
                                                    <th scope="row">{{index+1}}</th>
                                                    <td>{{form.product_name[index]}}</td>
                                                    <td>{{form.price[index]}} Tk</td>
                                                    <td>{{form.quantity[index]}} Pcs</td>
                                                    <td>{{form.price[index]*form.quantity[index]}} Tk</td>
                                                    <td><button type="button" class="btn btn-danger" @click="removeProduct(index)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    </td>
                                                </tr>

                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <th>Sub Total</th>
                                                    <td>{{subTotal}} Tk</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <th>Shipping Cost (+)</th>
                                                    <td>{{ form.shipping_cost  }} Tk</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <th>Discount Total (-)</th>
                                                    <td>{{ parseFloat(form.discount) + parseFloat(percentDiscount)  }} Tk</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <th>Grand Total</th>
                                                    <td>{{parseFloat(subTotal) + parseFloat(form.shipping_cost) - parseFloat(form.discount) - parseFloat(percentDiscount)  }} Tk</td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>

                                </div>


                                <input v-if="!editmode" v-model="form.status='new'" type="hidden">
                                <input v-if="!editmode" v-model="form.created_way='manual'" type="hidden">
                                <input v-if="!editmode" v-model="form.user=currentUser" type="hidden">





                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
    import VueTagsInput from "@johmun/vue-tags-input";
    import moment from 'moment';
    import vSelect from "vue-select";
    import _ from 'lodash';
    import Datepicker from 'vuejs-datepicker';


    export default {
        components: {
            VueTagsInput,
            vSelect,
            Datepicker,
        },
        data () {
            return {
                editmode: false,
                orders: {},
                form: new Form({
                    id : '',
                    shipping_date : '',
                    created_way : '',
                    name: '',
                    address: '',
                    district_code: '',
                    phone: '',
                    payment_method: '',
                    coupon: '',
                    shipping_title: '',
                    shipping_cost: 0,
                    note: '',
                    status: '',
                    user: '',
                    product_id: [],
                    product_name: [],
                    sku: [],
                    quantity: [],
                    price: [],
                    variation_id: [],
                    discount: 0,
                    discount_percent: 0,
                }),
                paymentMethods: [],
                shippings: [],
                currentUser: user.name,

                options: [],
                diniOptions: "",

                result1: "",
                addQuantity: 1,

                product_id1: [],
                sku1: [],
                quantity1: [],
                price1: [],
                product_name1: [],
                variation_id1: [],
                main_variation_id: 0,
                variation_info: '',

                checked: false,

                diniData: {},

                form2: new Form({
                    order_id : '',
                    product_id: '',
                    product_name: '',
                    sku: '',
                    quantity: '',
                    price: '',
                    variation_id: 0,
                }),
                variationSelect: false,
                options2: [],
                postOrderData: {
                    payment_method: "",
                    payment_method_title: "",
                    set_paid: true,
                    status: "",
                    billing: {
                        first_name: "",
                        address_1: "",
                        phone: ""
                    },
                    line_items: [],
                    shipping_lines: [
                        {
                            method_id: "",
                            method_title: "",
                            total: "0"
                        }
                    ]
                },

                per_page: "10",
                select_per_pages: [
                    10,20,30,50,'All'
                ],

                // serching

                start_date: "",
                end_date: "",

                state : {
                    disabledDates: {
                        from: new Date(),
                    }
                },

                shortingType: null,
                ascending: false,
                tableSearch: null,
            }
        },
        methods: {



            diniDateTime(date) {
                return moment(date).format('DD-MMMM-YYYY, h:mm a')
            },
            diniDate(date){
                return moment(date).format('DD/MM/YYYY')
            },

            getResults(page = 1) {

                this.$Progress.start();

                axios.get('api/order?page=' + page+'&per_page='+this.per_page).then(({ data }) => (this.orders = data.data));

                this.$Progress.finish();
            },
            loadOrders(){

                // if(this.$gate.isAdmin()){
                axios.get('api/order?per_page='+this.per_page).then(({ data }) => (this.orders = data.data));

                // }
            },

            loadProducts(){

                // if(this.$gate.isAdmin()){
                this.$Progress.start();

                diniApi.get("products")
                    .then((response) => {
                        let getData = [];
                        $.each(response.data, function(key, value) {

                            getData.push({
                                label: value.name,
                                code: value.id
                            });

                            // this.options = getData;
                            this.$Progress.finish();

                        });
                    })
                    .catch((error) => {
                        console.log(error);
                    })

                // }
            },


            newModal(){
                this.editmode = false;
                this.form.reset();
                this.product_id1 = [];
                this.sku1= [];
                this.quantity1= [];
                this.price1= [];
                this.product_name1= [];
                this.variation_id1= [];
                this.variationSelect= false;
                $('#addNew').modal('show');
            },

            newModal1(id){
                this.form2.reset();
                $('#products'+id).modal('show');
            },

            getPaymentMethod(){
                axios.get("api/payment-methods").then(({ data }) => (this.paymentMethods = data));
            },

            getShipping(){
                axios.get("api/shipping-titles").then(({ data }) => (this.shippings = data));
            },
            createOrder(){
                this.$Progress.start();

                this.form.post('api/order')
                    .then((data)=>{

                        if(data.statusText == 'OK'){
                            $('#addNew').modal('hide');
                            // console.log(data.data);

                            Toast.fire({
                                icon: 'success',
                                title: data.data.message
                            });
                            this.$Progress.finish();
                            this.loadOrders();

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch(()=>{

                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    })
            },

            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.result1 = [];
                    this.addQuantity = 1;
                    this.main_variation_id =0;
                    this.variationSelect = false;
                    this.options = [];
                    this.search(loading, search, this);

                }
            },
            search: _.debounce((loading, search, vm) => {

                fetch(
                    process.env.MIX_WC_URL+`/wp-json/`+process.env.MIX_WC_VERSION+`/products?search=${escape(search)}&consumer_key=`+process.env.MIX_WC_CONSUMER_KEY+`&consumer_secret=`+process.env.MIX_WC_CONSUMER_SECRET
                ).then(res => {
                    res.json().then(json => (vm.options = json));
                    loading(false);
                });
            }, 350),

            onSearch1(search, loading) {
                if(search.length) {
                    loading(true);
                    this.result1 = [];
                    this.addQuantity = 1;
                    this.main_variation_id =0;
                    this.variationSelect = false;
                    this.options = [];
                    this.search1(loading, search, this);
                }
            },
            search1: _.debounce((loading, search, vm) => {

                fetch(
                    process.env.MIX_WC_URL+`/wp-json/`+process.env.MIX_WC_VERSION+`/products?search=${escape(search)}&consumer_key=`+process.env.MIX_WC_CONSUMER_KEY+`&consumer_secret=`+process.env.MIX_WC_CONSUMER_SECRET
                ).then(res => {
                    res.json().then(json => (vm.options = json));
                    loading(false);
                });
            }, 350),

            addProduct(){
                if(this.result1.id){

                    this.product_id1.push(this.result1.id);
                    this.sku1.push(this.result1.sku);
                    this.quantity1.push(this.addQuantity);
                    this.price1.push(this.result1.price);
                    this.product_name1.push(this.result1.name);
                    this.variation_id1.push(this.main_variation_id);

                    this.result1 = [];
                    this.addQuantity = 1;
                    this.main_variation_id =0;
                    this.variationSelect = false;

                    this.form.product_id = this.product_id1;
                    this.form.product_name = this.product_name1;
                    this.form.sku = this.sku1;
                    this.form.quantity = this.quantity1;
                    this.form.price = this.price1;
                    this.form.variation_id = this.variation_id1;
                    this.options = [];

                }else{

                    Toast.fire({
                        icon: 'error',
                        title: 'Please select product'
                    });

                    this.result1 = [];
                    this.addQuantity = 1;
                    this.options = [];
                    this.main_variation_id =0;
                    this.variationSelect = false;

                }



            },

            addProductEdit(id){
                if(this.result1.id){
                    this.form2.reset();
                    this.form2.order_id = id;
                    this.form2.product_id = this.result1.id;
                    this.form2.product_name = this.result1.name;
                    this.form2.sku=this.result1.sku;
                    this.form2.quantity = this.addQuantity;
                    this.form2.price=this.result1.price;
                    this.form2.variation_id=this.main_variation_id;

                    this.form2.post('api/order-details')
                        .then((data)=>{
                            console.log(data);

                            if(data.statusText == 'OK'){

                                Toast.fire({
                                    icon: 'success',
                                    title: data.data.message
                                });
                                this.loadOrders();

                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Some error occured! Please try again'
                                });
                            }
                        })
                        .catch(()=>{

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });
                        })


                    this.result1 = '';
                    this.addQuantity = 1;
                    this.options = [];
                    this.main_variation_id =0;
                    this.variationSelect = false;

                }else{

                    Toast.fire({
                        icon: 'error',
                        title: 'Please select product'
                    });

                    this.result1 = '';
                    this.addQuantity = 1;
                    this.options = [];
                    this.main_variation_id =0;
                    this.variationSelect = false;

                }
            },
            removeProduct(index){
                this.product_id1.splice(index, 1);
                this.sku1.splice(index, 1);
                this.quantity1.splice(index, 1);
                this.price1.splice(index, 1);
                this.product_name1.splice(index, 1);
                this.variation_id1.splice(index, 1);

                this.result1 = [];
                this.addQuantity = 1;
                this.main_variation_id =0;
                this.variationSelect = false;

                this.form.product_id = this.product_id1;
                this.form.sku = this.sku1;
                this.form.product_name = this.product_name1;
                this.form.quantity = this.quantity1;
                this.form.price = this.price1;
                this.form.variation_id = this.variation_id1;
                this.options = [];
            },
            deleteProduct(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/order-details/'+id).then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Product has been deleted.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadOrders();
                        }).catch((data)=> {
                            console.log(data);
                            Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })

            },

            updateOrder(event, order_id){

                this.diniData[event.target.name] = event.target.value;

                this.$Progress.start();
                axios.put('api/order/'+order_id,this.diniData)
                    .then((response) => {
                        // success
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                        this.loadOrders();
                        this.diniData = {};
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        this.diniData = {};
                    });



            },

            updateOrderDetails(event, orderDetails_id){
                this.diniData[event.target.name] = event.target.value;

                this.$Progress.start();
                axios.put('api/order-details/'+orderDetails_id,this.diniData)
                    .then((response) => {
                        // success
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                        this.loadOrders();
                        this.diniData = {};
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        this.diniData = {};
                    });
            },

            getProductName(id){

                diniApi.get("products/"+id)
                    .then((response) => {
                        return response;
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            },

            variationLoad(){

                if(this.result1.type == "variable"){

                    let getData = [];
                    $.each(this.result1.variations, function(key, value) {

                        diniApi.get("products/"+value)
                            .then((response) => {
                                getData.push(response.data);
                            })
                            .catch((error) => {
                                console.log(error);
                            })


                    });
                    this.variationSelect = true;
                    this.options2 = getData;

                }

            },

            changeProductName(){
                this.result1.name = this.variation_info.name;
                this.result1.sku = this.variation_info.sku;
                this.main_variation_id = this.variation_info.id;
            },
            subTotalList(data){
                let newData = 0;
                $.each(data, function(key, value) {
                    newData += value.price * value.quantity;
                });

                return newData;
            },
            grandTotalList(data){
                let newData = 0;
                let duscountNew = 0;

                $.each(data.order_details, function(key, value) {
                    newData += value.price * value.quantity;
                });
                duscountNew = newData * data.discount_percent /100;

                newData = newData + data.shipping_cost - data.discount - duscountNew;

                return newData;
            },
            postOrder(event,id){


                if(event.target.value == 'confirm'){

                    this.$Progress.start();

                    this.orderSelectID = id;
                    let getData = this.postOrderData;
                    let getPaymentMethods = this.paymentMethods;
                    let listOrderData = this.filterOrders;
                    $.each(listOrderData, function(key, value) {

                        if(value.id == id){
                            getData.billing.first_name = value.name;
                            getData.billing.address_1 = value.address;
                            getData.billing.phone = value.phone;
                            getData.payment_method = value.payment_method;

                            $.each(getPaymentMethods, function(key1, value1) {
                                if(value1.method == value.payment_method){
                                    getData.payment_method_title = value1.pay_name;
                                }
                            });

                            getData.status = "processing";
                            getData.shipping_lines[0].method_id = value.shipping_title;
                            getData.shipping_lines[0].method_title = value.shipping_title;
                            getData.shipping_lines[0].total = value.shipping_cost.toString();

                            // console.log(value.discount);
                            // console.log(value.discount_percent);
                            // Product wise discount measure from fixed and Percent Discount

                            let duscountNew = 0;
                            let totalProductRow = 0;

                            $.each(value.order_details, function(key2, value2) {
                                duscountNew += value2.price * value2.quantity;
                                totalProductRow++;
                            });

                            duscountNew = duscountNew * value.discount_percent /100;

                            duscountNew = value.discount + duscountNew;
                            duscountNew = duscountNew / totalProductRow;


                            $.each(value.order_details, function(key3, value3) {
                                let totalPrice = 0;
                                totalPrice = value3.price * value3.quantity;
                                totalPrice = totalPrice - duscountNew;
                                getData.line_items.push({
                                    product_id: value3.product_id,
                                    quantity: value3.quantity,
                                    total: totalPrice.toString()
                                });
                            });




                        }


                    });

                    this.postOrderData = getData;

                    // Post Order


                    diniApi.post("orders",this.postOrderData)
                        .then((response)=>{

                            // console.log("Response Status:", response.status);
                            // console.log("Response Headers:", response.headers);
                            // console.log("Response Data:", response.data);

                            if(response.data.id){
                                var noteUrl = "orders/"+response.data.id+"/notes";
                                // Add Order Create note
                                diniApi.post(noteUrl,{
                                    note: "Order Created from local by"+user.name
                                })
                                    .then((response1)=>{
                                        // console.log("Response Status:", response1.status);
                                        // console.log("Response Headers:", response1.headers);
                                        // console.log("Response Data:", response1.data);

                                        if(response1.data.id){
                                            console.log("Note ok");
                                        } else {
                                            this.refreshPostOrderData();
                                            console.log("Add Order create note else Error");
                                            Toast.fire({
                                                icon: 'error',
                                                title: 'Some error occured! Please try again'
                                            });

                                            this.$Progress.failed();
                                        }
                                    })
                                    .catch((error)=>{
                                        this.refreshPostOrderData();
                                        console.log("Add Order create note  Error");
                                        // Invalid request, for 4xx and 5xx statuses
                                        // console.log("Response Status:", error.response.status);
                                        // console.log("Response Headers:", error.response.headers);
                                        // console.log("Response Data:", error.response.data);

                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Some error occured! Please try again'
                                        });
                                    });
                                // Update status processing to confirmed
                                var updateUrl = "orders/"+response.data.id;

                                diniApi.put(updateUrl,{
                                    status: "confirmed"
                                })
                                    .then((response)=>{

                                        // console.log("Response Status:", response.status);
                                        // console.log("Response Headers:", response.headers);
                                        // console.log("Response Data:", response.data);

                                        if(response.data.id){
                                            // Update on local data base

                                            let even = "";
                                            $.each(response.data.meta_data, function(key4, value4) {

                                                if(value4.key == "_wcpdf_invoice_number" ){
                                                    even =  value4.value;
                                                }


                                            });

                                            axios.put("api/order/"+id,{
                                                order_id: response.data.id,
                                                status: response.data.status,
                                                order_date: response.data.date_created,
                                                invoice_number: parseInt(even),
                                                active: 0,
                                            }).then((data)=>{

                                                if(data.statusText == 'OK'){
                                                    Toast.fire({
                                                        icon: 'success',
                                                        title: data.data.message
                                                    });

                                                    this.refreshPostOrderData();
                                                    this.$Progress.finish();
                                                    this.loadOrders();

                                                } else {
                                                    console.log("Update on local data base else Error");
                                                    this.refreshPostOrderData();
                                                    Toast.fire({
                                                        icon: 'error',
                                                        title: 'Some error occured! Please try again'
                                                    });

                                                    this.$Progress.failed();
                                                }
                                            })
                                                .catch(()=>{
                                                    console.log("Update on local data base Error");
                                                    this.refreshPostOrderData();
                                                    Toast.fire({
                                                        icon: 'error',
                                                        title: 'Some error occured! Please try again'
                                                    });
                                                });

                                        } else {
                                            console.log("Update status processing to confirmed else Error");
                                            this.refreshPostOrderData();
                                            Toast.fire({
                                                icon: 'error',
                                                title: 'Some error occured! Please try again'
                                            });

                                            this.$Progress.failed();
                                        }
                                    })
                                    .catch((error)=>{
                                        this.refreshPostOrderData();
                                        console.log("Update status processing to confirmed Error");
                                        // Invalid request, for 4xx and 5xx statuses
                                        // console.log("Response Status:", error.response.status);
                                        // console.log("Response Headers:", error.response.headers);
                                        // console.log("Response Data:", error.response.data);
                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Some error occured! Please try again'
                                        });
                                    });


                            } else {
                                this.refreshPostOrderData();
                                console.log("Post Order else Error");
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Some error occured! Please try again'
                                });

                                this.$Progress.failed();
                            }
                        })
                        .catch((error)=>{
                            this.refreshPostOrderData();
                            console.log("Post Order Error");
                            // Invalid request, for 4xx and 5xx statuses
                            // console.log("Response Status:", error.response.status);
                            // console.log("Response Headers:", error.response.headers);
                            // console.log("Response Data:", error.response.data);
                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });
                        });


                }

                if(event.target.value == "pre-cancel"){

                    this.$Progress.start();
                    axios.put('api/order/'+id,{status: "pre-cancel"})
                        .then((response) => {
                            // success
                            Toast.fire({
                                icon: 'success',
                                title: response.data.message
                            });
                            this.$Progress.finish();
                            //  Fire.$emit('AfterCreate');

                            this.loadOrders();
                            this.diniData = {};
                        })
                        .catch(() => {
                            this.$Progress.fail();
                            this.diniData = {};
                        });

                    console.log(id);
                }
                if(event.target.value == "un-cancel"){
                    this.$Progress.start();
                    axios.put('api/order/'+id,{status: "new"})
                        .then((response) => {
                            // success
                            Toast.fire({
                                icon: 'success',
                                title: response.data.message
                            });
                            this.$Progress.finish();
                            //  Fire.$emit('AfterCreate');

                            this.loadOrders();
                            this.diniData = {};
                        })
                        .catch(() => {
                            this.$Progress.fail();
                            this.diniData = {};
                        });

                }

            },

            refreshPostOrderData(){
                this.postOrderData.payment_method = "";
                this.postOrderData.payment_method_title = "";
                this.postOrderData.status = "";
                this.postOrderData.billing.first_name = "";
                this.postOrderData.billing.address_1 = "";
                this.postOrderData.billing.phone ="";
                this.postOrderData.line_items = [];
                this.postOrderData.shipping_lines[0].method_id = "";
                this.postOrderData.shipping_lines[0].method_title = "";
                this.postOrderData.shipping_lines[0].total = "";
            },

            changePagination(){
                this.loadOrders();
            },

            dateWiseOrder(){
                if(this.start_date && this.end_date){
                    if(this.start_date <= this.end_date){
                        var start = moment(this.start_date).format('YYYY-MM-DD');
                        var end = moment(this.end_date).format('YYYY-MM-DD');
                        console.log(start);
                        console.log(end);

                        this.$Progress.start();

                        axios.get('api/order/date?start_date='+start+'&end_date='+end).then(({ data }) => (this.orders = data.data));

                        this.$Progress.finish();

                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'Wrong date range selected'
                        });
                    }
                }else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Date range not selected'
                    });
                }

            },

            shoringOrders(type){
                this.shortingType = type;
                this.ascending = !this.ascending;
            }



        },
        mounted() {

        },
        created() {
            this.$Progress.start();

            this.loadOrders();
            this.getPaymentMethod();
            this.getShipping();
            this.$Progress.finish();
        },
        filters: {
            // truncate: function (text, length, suffix) {
            //     return text.substring(0, length) + suffix;
            // },
        },
        computed: {
            filteredItems() {
                return this.autocompleteItems.filter(i => {
                    return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
                });
            },
            subTotal: function() {
                let total = 0;
                let data = this.form;
                $.each(this.form.product_id, function(key, value) {
                    total += data.price[key]*data.quantity[key];

                });

                return total;
            },

            percentDiscount: function() {
                let total1 = 0;
                let subTotal1 = this.subTotal;
                total1 = subTotal1*this.form.discount_percent;
                total1 = total1/100;
                return total1;
            },

            filterOptions: function(){
                return this.options.filter(option => !option.stock_status.indexOf("instock"))
            },

            filterOrders: function () {

                let orders  = this.orders.data;
                let searchQuery =this.tableSearch;
                let shortType = this.shortingType;

                // Process search input
                if (searchQuery != null && searchQuery) {
                    orders = orders.filter((item) => {
                        return item.name
                            .toUpperCase()
                            .includes(searchQuery.toUpperCase()) || item.address
                            .toUpperCase()
                            .includes(searchQuery.toUpperCase()) || item.phone
                            .toUpperCase()
                            .includes(searchQuery.toUpperCase())
                    })
                }

                if(shortType){
                    // Sort by date order
                    if(shortType == "date"){
                        orders = orders.sort((a, b) => {return a.created_at - b.created_at});

                        // Show sorted array in descending or ascending order
                        if (!this.ascending) {
                            orders.reverse()
                        }

                        // return orders;
                    }else if(shortType == "name"){
                        // Sort by name alphabetical order
                        orders = orders.sort((a, b) => {
                            let fa = a.name.toLowerCase(), fb = b.name.toLowerCase()

                            if (fa < fb) {
                                return -1
                            }
                            if (fa > fb) {
                                return 1
                            }
                            return 0

                        });

                        if (!this.ascending) {
                            orders.reverse()
                        }

                        // return orders;
                    }
                    else if(shortType == "address"){
                        // Sort by address alphabetical order
                        orders = orders.sort((a, b) => {
                            let fa = a.address.toLowerCase(), fb = b.address.toLowerCase()

                            if (fa < fb) {
                                return -1
                            }
                            if (fa > fb) {
                                return 1
                            }
                            return 0

                        });

                        if (!this.ascending) {
                            orders.reverse()
                        }

                        // return orders;
                    }
                    else if(shortType == "payment_method"){
                        // Sort by pay method alphabetical order
                        orders = orders.sort((a, b) => {
                            let fa = a.payment_method.toLowerCase(), fb = b.payment_method.toLowerCase()

                            if (fa < fb) {
                                return -1
                            }
                            if (fa > fb) {
                                return 1
                            }
                            return 0

                        });

                        if (!this.ascending) {
                            orders.reverse()
                        }

                        // return orders;
                    }
                    else if(shortType == "shipping_title"){
                        // Sort by shipping titles alphabetical order
                        orders = orders.sort((a, b) => {
                            let fa = a.shipping_title.toLowerCase(), fb = b.shipping_title.toLowerCase()

                            if (fa < fb) {
                                return -1
                            }
                            if (fa > fb) {
                                return 1
                            }
                            return 0

                        });

                        if (!this.ascending) {
                            orders.reverse()
                        }

                        // return orders;
                    }
                    else if(shortType == "status"){
                        // Sort by shipping titles alphabetical order
                        orders = orders.sort((a, b) => {
                            let fa = a.status.toLowerCase(), fb = b.status.toLowerCase()

                            if (fa < fb) {
                                return -1
                            }
                            if (fa > fb) {
                                return 1
                            }
                            return 0

                        });

                        if (!this.ascending) {
                            orders.reverse()
                        }

                        // return orders;
                    }

                }


                return orders;


            },











        },
    }
</script>

<style scoped>

    .header {
        position: sticky;
        top:0;
    }

    .mytable {
        height: 600px;
        overflow: auto;
    }


</style>
