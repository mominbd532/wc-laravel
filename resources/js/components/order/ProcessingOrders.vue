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
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" @change="orderSearch($event)">
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

                            <h3 class="card-title">Processing Order</h3>

                            <select v-model="selectedAction" class="ml-2">
                              <option disabled value="">Please select one</option>
                               <option v-for="(orderStatus,index) in orderStatuses" :key="index" :value="orderStatus.status">Change status to {{orderStatus.name}}</option>
                            </select>
                            <button type="button" class="btn btn-sm btn-info" @click="multiActions" :disabled="!selectedAction">Action</button>

                            <div class="card-tools">
                                <!-- <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                                    <i class="fa fa-plus-square"></i>
                                    Add New
                                </button> -->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="mytable">
                                <table class="table table-hover">
                                    <thead style="position: sticky; top: 0" class="thead-dark">
                                    <tr>
                                        <th class="header"><label class="form-checkbox mb-0"><input type="checkbox" v-model="selectAll" @click="selectALLRow"><i class="form-icon"></i></label></th>
                                        <th class="header">Id</th>
                                        <th class="header">Date</th>
                                        <th class="header">Name</th>
                                        <th class="header">Address</th>
                                        <th class="header">Phone</th>
                                        <th class="header my-white-space">Sub Total</th>
                                        <th class="header">Discount</th>
                                        <th class="header">Shipping Titles</th>
                                        <th class="header">Shipping Cost</th>
                                        <th class="header my-white-space">Grand Total</th>
                                        <th class="header">Payment Method</th>
                                        <th class="header">Status</th>
                                        <th class="header">Notes</th>
                                        <th class="header">Txn Number</th>
                                        <th class="header">Txn Id</th>
                                        <th class="header my-white-space">Coupon Id</th>
                                        <th class="header my-white-space">Order Created Way</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr v-for="order in orders">
                                        <td><input type="checkbox" :value="order" v-model="selectedRow"></td>
                                        <td><a href="#" @click="productModal(order.id)">{{order.id}}</a></td>
                                        <td><a href="#" @click="genaratePDF(order.id)" style="display: flex; width: 135px;">{{diniDateTime(order.date_created)}}</a></td>

                                        <td>
                                            <input :value="order.billing.first_name" type="text" name="name" @change="updateBillingName($event,order.id)"  style="width: 150px" class="form-control">
                                        </td>
                                        <td>
                                            <textarea name="address" required="required" @change="updateBillingAddress($event, order.id)">{{order.billing.address_1}}</textarea>
                                        </td>
                                        <td>
                                            <input :value="order.billing.phone" type="text" name="phone" required="required" @change="updateBillingPhone($event, order.id)" class="form-control" style="width: 140px;">
                                        </td>


                                        <td><p style="white-space: nowrap;">{{parseInt(order.total) + parseInt(order.discount_total) - parseInt(order.shipping_total)}} TK</p></td>
                                        <td>
                                            <input :value="order.discount_total" type="number" name="discount" class="form-control" style="width: 100px;" @change="updateDiscount($event, order)">
                                        </td>
                                        <td>
                                            <input v-if="order.shipping_lines.length > 0" :value="order.shipping_lines[0].method_title" type="text" name="shipping_method"
                                                class="form-control" style="width: 150px;" @change="updateShippingTitles($event, order)" >
                                        </td>
                                        <td>
                                            <input :value="order.shipping_total" type="number" name="shipping_cost" class="form-control" style="width: 100px;" @change="updateShippingCost($event, order)" >

                                        </td>

                                        <td><p style="white-space: nowrap;">{{order.total}} TK</p></td>
                                        <td>
                                            <select class="form-control" name="payment_method" style="width: fit-content;" @change="updatePaymentMethod($event, order.id)">
                                                <option v-for="(payment,index) in paymentMethods" :key="index" :selected="order.payment_method == payment.method" >{{payment.pay_name}}</option>
                                            </select>

                                        </td>

                                        <td>
                                            <select class="form-control" name="status" style="width: fit-content;" @change="updateOrderStatus($event, order.id)" >
                                                <option v-for="(orderStatus,index) in orderStatuses" :key="index" :value="orderStatus.status" :selected="order.status == orderStatus.status" >{{orderStatus.name}}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" @click="notesModal(order.id)">Notes</button>

                                        </td>
                                        <td>
                                            <input :value="order.txn_num" type="text" name="txn_num"
                                                class="form-control" style="width: fit-content;" @change="order.order_id ? updateOrderTest($event, order.id, order.order_id) : updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'">

                                        </td>
                                        <td>
                                            <input :value="order.txn_id" type="text" name="txn_id"
                                                class="form-control"style="width: fit-content;" @change="order.order_id ? updateOrderTest($event, order.id, order.order_id) : updateOrder($event, order.id)" :readonly="order.status == 'pre-cancel'">

                                        </td>
                                        <td>
                                            <button v-if="order.coupon_lines.length > 0" type="button" class="btn btn-secondary" @click="couponsModal(order.id)">Coupons</button>

                                        </td>

                                        <td>{{order.created_via}}</td>

                                         <!--Note Modal -->

                                          <div class="modal fade" :id="`notes${order.id}`" tabindex="-1" role="dialog" aria-labelledby="editProduct" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Notes List for Invoice:
                                                            <span v-for="meta_info in order.meta_data" v-if="meta_info.key == '_wcpdf_invoice_number'">{{meta_info.value}}</span>
                                                        </h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="notes" v-for="noteN in orderNotes">
                                                            <div class="note_content">
                                                                <p>
                                                                    {{noteN.note}}
                                                                </p>
                                                            </div>
                                                            <div class="note_date">{{diniDateTime(noteN.date_created)}}</div>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                        <!--Coupon Modal -->
                                        <div class="modal fade" :id="`coupon${order.id}`" tabindex="-1" role="dialog" aria-labelledby="editProduct" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Coupons List for Invoice:
                                                            <span v-for="meta_info in order.meta_data" v-if="meta_info.key == '_wcpdf_invoice_number'">{{meta_info.value}}</span>
                                                        </h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Code</th>
                                                            <th scope="col">Amount</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(line, index) in order.coupon_lines" :key="index">
                                                            <th scope="row">{{index+1}}</th>
                                                            <td>{{line.code}}</td>
                                                            <td>{{line.discount}}</td>
                                                            </tr>

                                                        </tbody>
                                                        </table>

                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                        <!--Products Modal -->
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
                                                                <input v-model="addQuantity" type="number" name="quantity" class="form-control">
                                                            </div>
                                                            <div class="col-2">
                                                                <button type="button" class="btn btn-success mt-4" @click="productAddUpdate(order.id)">
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
                                                                        <th scope="col">Variation</th>
                                                                        <th scope="col">Price</th>
                                                                        <th scope="col">Quantity</th>
                                                                        <th scope="col">Total</th>
                                                                        <th scope="col">Action</th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                    <tr v-for="(detail,index) in order.line_items" :key="index">
                                                                        <th scope="row">{{index+1}}</th>
                                                                        <td>{{detail.name}}</td>
                                                                        <td>{{detail.sku}}</td>
                                                                        <td>{{detail.variation_id}}</td>
                                                                        <td>
                                                                            {{parseInt(detail.subtotal)/detail.quantity}}
                                                                        </td>
                                                                        <td>
                                                                            {{detail.quantity}}
                                                                        </td>
                                                                        <td>
                                                                            {{detail.subtotal}}
                                                                        </td>
                                                                        <td><button type="button" class="btn btn-danger" @click="productDeleteUpdate(order, detail)">
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


                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row" v-if="pageinateShow">
                                <div class="col-6">
                                    <label for="cars">Per page:</label>

                                    <select v-model="per_page" @change="callback(page)">
                                        <option>10</option>
                                        <option>20</option>
                                        <option>50</option>
                                        <option>100</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <pagination :records="records" v-model="page" :per-page="parseInt(per_page)" @paginate="callback" class="float-right" > </pagination>
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
                            <h5 class="modal-title" >Create New order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="createOrder()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" v-model="postOrderData.billing.first_name">
                                        </div>
                                        <div class="col-3">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" v-model="postOrderData.billing.address_1" >
                                        </div>
                                        <div class="col-3">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" v-model="postOrderData.billing.phone">
                                        </div>
                                        <div class="col-3">
                                            <label>Email</label>
                                            <input type="text" name="email" class="form-control" v-model="postOrderData.billing.email">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>Payment Method</label>
                                            <select class="form-control" v-model="paymentData" >
                                                <option v-for="(payment,index) in paymentMethods" :key="index" :value="payment" :selected="payment.id == 1">{{payment.pay_name}}</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label>Shipping Title</label>
                                            <select class="form-control" v-model="shippingData">
                                                <option v-for="(ship,index) in shippings" :key="index"
                                                    :value="ship.ship_title">{{ship.ship_title}}</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label>Shipping Cost</label>
                                            <input type="number" name="shipping_cost" class="form-control" v-model="postOrderData.shipping_lines[0].total">
                                        </div>
                                        <div class="col-2">
                                            <label>Fixed Discount</label>
                                            <input type="number" name="discount" class="form-control" v-model="fixedDiscount">
                                        </div>
                                        <div class="col-2">

                                            <label>Percent Discount</label>
                                            <input type="number" name="discount_percent" class="form-control" v-model="pcntDiscount">
                                        </div>
                                    </div>

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

                                            <select v-if="variationSelect" v-model="variation_info" @change="changeProductName" style="width: 100%; margin-bottom: 10px">
                                                <option v-if="variation.stock_status = 'instock'" v-for="(variation,index) in options2" v-bind:value="{id: variation.id, name: variation.name, sku: variation.sku }">
                                                    {{variation.name}} - ({{variation.sku}})
                                                </option>
                                            </select>

                                        </div>
                                        <div class="col-3">
                                            <label>Quantity</label>
                                            <input v-model="addQuantity" type="number" name="quantity"
                                                   class="form-control" >
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
                                                    <th scope="col">SKU</th>
                                                    <th scope="col">Variation</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr v-for="(product, index) in productsData" :key="index">
                                                    <th scope="row">{{index+1}}</th>
                                                    <td>{{product.name}}</td>
                                                    <td>{{product.sku}}</td>
                                                    <td>{{product.variation_id}}</td>
                                                    <td>{{product.price}}Tk</td>
                                                    <td>{{product.quantity}}</td>
                                                    <td>{{product.price*product.quantity}}Tk</td>
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
                                                    <td></td>
                                                    <td></td>
                                                    <th>Shipping Cost (+)</th>
                                                    <td>{{postOrderData.shipping_lines[0].total}} Tk</td>

                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <th>Discount Total (-)</th>
                                                    <td>{{parseInt(fixedDiscount)+parseInt(percentDiscount)}} Tk</td>

                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <th>Grand Total</th>
                                                    <td>{{parseInt(subTotal)+parseInt(postOrderData.shipping_lines[0].total)-parseInt(fixedDiscount)-parseInt(percentDiscount)}} Tk</td>

                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>

                                </div>





                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
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
    import Pagination from 'vue-pagination-2';
    import Datepicker from 'vuejs-datepicker';


    export default {
        components: {
            VueTagsInput,
            vSelect,
            Pagination,
            Datepicker,
        },
        data () {
            return {

                orders: [],
                postOrderData: {
                    payment_method: '',
                    payment_method_title: '',
                    set_paid: true,
                    status: 'processing',
                    billing: {
                        first_name: null,
                        address_1: null,
                        phone: null,
                        email: null
                      },
                    line_items: [],
                    shipping_lines: [
                        {
                          method_id: '',
                          method_title: '',
                          total: "0"
                        }
                      ]
                },

                paymentData: '',
                shippingData: 'RedX Home Delivery',
                fixedDiscount: 0,
                pcntDiscount: 0,
                productsData: [],

                paymentMethods: [],
                shippings: [],
                orderStatuses: [],
                currentUser: user.name,

                checked: false,


                options: [],

                result1: "",
                addQuantity: 1,
                variation_id: 0,

                variationSelect: false,
                options2: [],
                variation_info: '',


                page: 1,
                records: 0,
                per_page: 10,
                start_date: "",
                end_date: "",
                state : {
                    disabledDates: {
                        from: new Date(),
                    }
                },

                pageinateShow: true,
                dateWisePage: 1,

                orderNotes: [],

                selectedRow: [],
                selectAll: false,

                selectedAction: '',

                localUrl: window.location.origin,



            }
        },
        methods: {



            diniDateTime(date) {
                return moment(date).format('DD-MMMM-YYYY, h:mm a')
            },
            diniDate(date){
                return moment(date).format('DD/MM/YYYY')
            },

            getWebOrders(){

                diniApi.get("orders?status=processing")
                    .then((response) => {

                        this.orders = response.data;

                    })
                    .catch((error) => {
                        console.log(error);
                    })
            },
            callback: function(page) {

                diniApi.get("orders?status=processing&page="+page+"&per_page="+this.per_page)
                    .then((response) => {
// console.log(response);
                        this.orders = response.data;

                    })
                    .catch((error) => {
                      console.log(error);
                    })
                // console.log(`Page ${page} was selected. Do something about it`);
            },

            getOrderTotals(){
                diniApi.get("reports/orders/totals")
                    .then((response) => {

                        let newData = 0;
                        $.each(response.data, function(key, value) {
                            if(value.slug == "processing"){
                                newData = value.total;
                            }
                        });

                        this.records = newData;

                    })
                    .catch((error) => {
                      console.log(error);
                    })
            },

            dateWiseOrder(){
                if(this.start_date && this.end_date){
                    if(this.start_date <= this.end_date){
                      this.dateWisePage = 1;
                      this.orders = [];
                      this.pageinateShow = false;
                      this.dateWiseOrderLoop();
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

            dateWiseOrderLoop(){
                var start = moment(this.start_date).format('YYYY-MM-DD');
                var end = moment(this.end_date).format('YYYY-MM-DD');

                this.$Progress.start();




                diniApi.get("orders?after="+start+"T00:00:00&before="+end+"T00:00:00&page="+this.dateWisePage+"&per_page=100&status=processing")
                    .then((response) => {

                        if(response.data.length){

                            this.orders = this.orders.concat(response.data);
                            this.dateWisePage = this.dateWisePage + 1;
                            this.dateWiseOrderLoop();
                        }

                    })
                    .catch((error) => {
                        console.log(error);
                    })

                this.$Progress.finish();
            },

            orderSearch(event){

                  this.orders = [];
                  this.pageinateShow = false;

                 this.$Progress.start();

                diniApi.get("orders?search="+event.target.value+"&status=processing")
                    .then((response) => {
                            this.orders = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    })

                this.$Progress.finish();

            },



            newModal(){
                    this.refreshPostOrderData();
                    this.result1 = [];
                    this.addQuantity = 1;
                    this.variation_id = 0;
                    this.variationSelect = false;
                    this.options = [];
                    this.options2= [];
                    this.variation_info= '';

                $('#addNew').modal('show');
            },

            notesModal(id){

                diniApi.get("orders/"+id+"/notes")
                    .then((response) => {

                      this.orderNotes = response.data;

                    })
                    .catch((error) => {
                      console.log(error);
                    })

                $('#notes'+id).modal('show');
            },

            couponsModal(id){
                $('#coupon'+id).modal('show');
            },

            productModal(id){
                $('#products'+id).modal('show');
            },

            getPaymentMethod(){
                axios.get("api/payment-methods").then(({ data }) => (this.paymentMethods = data));
            },

            getShipping(){
                axios.get("api/shipping-titles").then(({ data }) => (this.shippings = data));
            },

            getOrderStatuses(){

                this.orderStatuses = [
                    {'name': 'On hold','status': 'on-hold'},
                    {'name': 'Cancelled','status': 'cancelled'},
                    {'name': 'Confirmed','status': 'confirmed'},
                ]
            },


            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.result1 = [];
                    this.addQuantity = 1;
                    this.variation_id = 0;
                    this.variationSelect = false;
                    this.options = [];
                    this.options2= [];
                    this.variation_info= '';
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
                    this.variation_id = 0;
                    this.variationSelect = false;
                    this.options = [];
                    this.options2= [];
                    this.variation_info= '';
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
                this.variation_id = this.variation_info.id;
            },

            addProduct(){
                if(this.result1.id){

                    this.result1['quantity'] = this.addQuantity;
                    this.result1['variation_id'] = this.variation_id;

                    this.productsData.push(this.result1);

                    this.result1 = [];
                    this.addQuantity = 1;
                    this.variation_id = 0;
                    this.variationSelect = false;
                    this.options = [];
                    this.options2= [];
                    this.variation_info= '';

                }else{

                    Toast.fire({
                        icon: 'error',
                        title: 'Please select product'
                    });

                    this.result1 = [];
                    this.addQuantity = 1;
                    this.variation_id = 0;
                    this.variationSelect = false;
                    this.options = [];
                    this.options2= [];
                    this.variation_info= '';

                }
            },

            removeProduct(index){
                this.productsData.splice(index, 1);

                this.result1 = [];
                this.addQuantity = 1;
                this.variation_id = 0;
                this.variationSelect = false;
                this.options = [];
                this.options2= [];
                this.variation_info= '';
            },


            createOrder(){

                this.paymentDataPass;
                this.shippingDataPass;
                this.productAdding;
                     this.$Progress.start();

                    if(this.postOrderData.billing.first_name && this.postOrderData.billing.address_1 && this.postOrderData.billing.phone && this.postOrderData.payment_method){

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
                                                note: "Order Created from local by Id:"+user.id+" Name: "+user.name
                                            })
                                                .then((response1)=>{
                                                    // console.log("Response Status:", response1.status);
                                                    // console.log("Response Headers:", response1.headers);
                                                    // console.log("Response Data:", response1.data);

                                                    if(response1.data.id){
                                                        //
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
                                                         Toast.fire({
                                                               icon: 'success',
                                                               title: 'Order created successfully'
                                                             });
                                                            this.refreshPostOrderData();
                                                            this.getWebOrders();
                                                            this.$Progress.finish();
                                                            this.$router.push('web-orders');


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



                    }else{
                         Toast.fire({
                                icon: 'error',
                                title: 'Please fill all info'
                            });
                    }


            },



            refreshPostOrderData(){
                this.postOrderData.payment_method = "";
                this.postOrderData.payment_method_title = "";
                this.postOrderData.billing.first_name = "";
                this.postOrderData.billing.address_1 = "";
                this.postOrderData.billing.phone ="";
                this.postOrderData.billing.email ="";
                this.productsData = [];
                this.fixedDiscount = 0,
                this.pcntDiscount = 0,
                this.shippingData = "RedX Home Delivery";
                this.postOrderData.shipping_lines[0].total = "0";
                this.result1 = [];
                this.addQuantity = 1;
                this.variation_id = 0;
                this.variationSelect = false;
                this.options = [];
                this.options2= [];
                this.variation_info= '';
                this.selectedRow= [];
                this.selectAll= false;
                this.selectedAction= '';
            },

            updateBillingName(event, id){

// Update status Billing Name
                var updateUrl = "orders/"+id;
                this.$Progress.start();
                diniApi.put(updateUrl,{
                    billing: {
                        first_name: event.target.value
                    }
                })
                    .then((response)=>{


                        if(response.data.id == id){

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Billing Name by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });


                        } else {
                            console.log("Update status processing to confirmed else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

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

            },

            updateBillingAddress(event, id){

// Update status Billing Name
                var updateUrl = "orders/"+id;
                this.$Progress.start();
                diniApi.put(updateUrl,{
                    billing: {
                        address_1: event.target.value
                    }
                })
                    .then((response)=>{


                        if(response.data.id == id){

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Billing Address by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });


                        } else {
                            console.log("Update status processing to confirmed else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

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

            },

            updateBillingPhone(event, id){

// Update status Billing Name
                var updateUrl = "orders/"+id;
                this.$Progress.start();
                diniApi.put(updateUrl,{
                    billing: {
                        phone: event.target.value
                    }
                })
                    .then((response)=>{


                        if(response.data.id == id){

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Billing Phone by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });


                        } else {
                            console.log("Update status processing to confirmed else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

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

            },

            updatePaymentMethod(event, id){

                 let payData = [];
                payData =  this.paymentMethods.filter(method => !method.pay_name.indexOf(event.target.value));
                // console.log(payData[0]);

                // Update status payment method
                var updateUrl = "orders/"+id;
                this.$Progress.start();
                diniApi.put(updateUrl,{
                    payment_method: payData[0].method,
                    payment_method_title: payData[0].pay_name,
                })
                    .then((response)=>{


                        if(response.data.id == id){

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Payment Method by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });


                        } else {
                            console.log("Update else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

                        console.log("Update status processing to confirmed Error");
                        console.log(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    });


            },

            updateShippingTitles(event, order){



                // Update status payment method
                var updateUrl = "orders/"+order.id;
                this.$Progress.start();
                diniApi.put(updateUrl,{
                    shipping_lines: [
                        {
                            id: order.shipping_lines[0].id,
                            method_id: event.target.value,
                            method_title: event.target.value,
                        }
                    ]
                })
                    .then((response)=>{


                        if(response.data.id == order.id){

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Shipping Titles by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });


                        } else {
                            console.log("Update status processing to confirmed else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

                        console.log("Update status processing to confirmed Error");
                        console.log(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    });


            },

            updateShippingCost(event, order){

                   // Update status payment method
                var updateUrl = "orders/"+order.id;
                this.$Progress.start();
                diniApi.put(updateUrl,{
                    shipping_lines: [
                        {
                            id: order.shipping_lines[0].id,
                            total: event.target.value,
                        }
                    ]
                })
                    .then((response)=>{


                        if(response.data.id == order.id){

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Shipping Cost by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });


                        } else {
                            console.log("Update status processing to confirmed else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

                        console.log("Update status processing to confirmed Error");
                        console.log(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    });


            },

            updateOrderStatus(event, id){

                // Update status processing to confirmed
                var updateUrl = "orders/"+id;
                this.$Progress.start();
                diniApi.put(updateUrl,{
                    status: event.target.value
                })
                    .then((response)=>{

                        if(response.data.id == id){
                            // Add note

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Status by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });



                        } else {
                            console.log("Update else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

                        console.log("Update status processing to confirmed Error");
                        console.kog(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    });

            },

            updateDiscount(event, order){

                   let perDis = 0;
                   let products = {
                    line_items: [],
                   };

                   let product = '';

                   perDis = parseInt(event.target.value) / order.line_items.length;


                   $.each(order.line_items, function(key, value) {

                    let newTotal = 0;
                   newTotal = parseInt(value.subtotal) - perDis;

                    product = {
                            id: value.id,
                            total: newTotal.toString(),
                        };


                   products.line_items.push(product);

                    });

                   // console.log(products);

                    var updateUrl = "orders/"+order.id;
                this.$Progress.start();
                diniApi.put(updateUrl,products)
                    .then((response)=>{

                        if(response.data.id == order.id){
                            // Add note

                            var noteUrl = "orders/"+response.data.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: "Update Order Discount by Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{


                                    if(response1.data.id){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Order update successfully'
                                        });
                                        this.getWebOrders();
                                        this.$Progress.finish();

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

                                    console.log(error);

                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });



                        } else {
                            console.log("Update else Error");

                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch((error)=>{

                        console.log("Update status processing to confirmed Error");
                        console.kog(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    });



            },

            productAddUpdate(order_id){


                    if(this.result1.id){
                        let sendData = "";

                        if(this.variation_id > 0){
                            sendData = {
                                            line_items: [
                                                {
                                                    product_id: this.result1.id,
                                                    variation_id: this.variation_id,
                                                    quantity: this.addQuantity,
                                                }
                                            ]
                                        }

                        }else{
                             sendData = {
                                            line_items: [
                                                {
                                                   product_id: this.result1.id,
                                                   quantity: this.addQuantity,
                                                }
                                            ]
                                        }

                        }

                                // Update status payment method
                    var updateUrl = "orders/"+order_id;
                    this.$Progress.start();
                    diniApi.put(updateUrl,sendData)
                        .then((response)=>{


                            if(response.data.id == order_id){

                                var noteUrl = "orders/"+response.data.id+"/notes";
                                // Add Order Create note
                                diniApi.post(noteUrl,{
                                    note: "Product added Name by Id:"+user.id+" Name: "+user.name
                                })
                                    .then((response1)=>{


                                        if(response1.data.id){
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'Order update successfully'
                                            });
                                            this.getWebOrders();
                                            this.refreshPostOrderData();
                                            this.$Progress.finish();

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

                                        console.log(error);

                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Some error occured! Please try again'
                                        });
                                    });


                            } else {
                                this.refreshPostOrderData();
                                console.log("Update order else Error");

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
                            console.log(error);
                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });
                        });
                    }else{

                        Toast.fire({
                                icon: 'error',
                                title: 'Please select product'
                            });


                            this.refreshPostOrderData();

                    }


            },

            productDeleteUpdate(order_info, detail_info){

                                // Delete product
                    var updateUrl = "orders/"+order_info.id;
                    this.$Progress.start();
                    diniApi.put(updateUrl,{
                        line_items: [
                                      {
                                        id: detail_info.id,
                                        quantity: 0,
                                       }
                                    ]
                    })
                        .then((response)=>{


                            if(response.data.id == order_info.id){

                                var noteUrl = "orders/"+response.data.id+"/notes";
                                // Add Order Create note
                                diniApi.post(noteUrl,{
                                    note: "Product added Name by Id:"+user.id+" Name: "+user.name
                                })
                                    .then((response1)=>{


                                        if(response1.data.id){
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'Order update successfully'
                                            });
                                            this.getWebOrders();
                                            this.refreshPostOrderData();
                                            this.$Progress.finish();

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

                                        console.log(error);

                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Some error occured! Please try again'
                                        });
                                    });


                            } else {
                                this.refreshPostOrderData();
                                console.log("Update order else Error");

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
                            console.log(error);
                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });
                        });
            },

            selectALLRow() {
            this.selectedRow = [];
            if (!this.selectAll) {
                for (let i in this.orders) {
                    this.selectedRow.push(this.orders[i]);
                }
            }
            },

            multiActions(){

                if(this.selectedRow.length > 0){
                    console.log(this.selectedAction);
                    let multiPost = {};

                    let noteData = "";

                    let selectedRowData =this.selectedRow;

                    // Batch order status changed to processing

                    if(this.selectedAction == "processing"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to processing by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "processing"
                            });
                        });

                        this.batchOrderUpdate(multiPost, noteData );
                    }


                    // Batch order status changed to on-hold

                    if(this.selectedAction == "on-hold"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to on hold by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "on-hold"
                            });
                        });
                        this.batchOrderUpdate(multiPost, noteData );
                    }

                    // Batch order status changed to confirmed

                    if(this.selectedAction == "confirmed"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to confirmed by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "confirmed"
                            });
                        });

                        this.batchOrderUpdate(multiPost, noteData );
                    }


                    // Batch order status changed to shipping

                    if(this.selectedAction == "in-transit"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to In Transit by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "in-transit"
                            });
                        });
                        this.batchOrderUpdate(multiPost, noteData );
                    }

                    // Batch order status changed to delivered

                    if(this.selectedAction == "delivered"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to delivered by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "delivered"
                            });
                        });
                        this.batchOrderUpdate(multiPost, noteData );
                    }

                    // Batch order status changed to return

                    if(this.selectedAction == "returned"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to Returned by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "returned"
                            });
                        });

                        this.batchOrderUpdate(multiPost, noteData );
                    }

                    // Batch order status changed to shipping-hold

                    if(this.selectedAction == "completed"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to completed by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "completed"
                            });
                        });

                        this.batchOrderUpdate(multiPost, noteData );
                    }


                    // Batch order status changed to completed

                    if(this.selectedAction == "cancelled"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to cancelled by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "cancelled"
                            });
                        });

                        this.batchOrderUpdate(multiPost, noteData );
                    }

                    // Batch order status changed to cancelled

                    if(this.selectedAction == "refunded"){

                        multiPost = {update: []};

                        noteData = "Batch Order status update to refunded by";

                        $.each(selectedRowData, function(key, value) {
                            multiPost.update.push({
                                id: value.id,
                                status: "refunded"
                            });
                        });

                        this.batchOrderUpdate(multiPost, noteData );
                    }

                    // Batch invoice print

                    if(this.selectedAction == "bulk_invoice"){

                        let ids = []

                        $.each(selectedRowData, function(key, value) {

                            ids.push(value.id);

                        });

                        var strIDS = ids.toString();

                        // console.log(str1);

                        window.open(window.location.origin+"/batch-invoice?orderID="+strIDS, '_blank');


                    }


                    // console.log(multiPost);
                    // console.log(noteData);



                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Please select minimum one row'
                    });
                }



            },


            batchOrderUpdate: function(data, notes){

                let selectedRowData =this.selectedRow;

                this.$Progress.start();
                diniApi.post("orders/batch",data)
                    .then((response)=>{
                        // console.log(response);

                        $.each(selectedRowData, function(key, value) {
                            var noteUrl = "orders/"+value.id+"/notes";
                            // Add Order Create note
                            diniApi.post(noteUrl,{
                                note: notes+" Id:"+user.id+" Name: "+user.name
                            })
                                .then((response1)=>{
                                    //
                                })
                                .catch((error)=>{
                                    console.log(error);
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Some error occured! Please try again'
                                    });
                                });

                        });



                        Toast.fire({
                            icon: 'success',
                            title: 'Batch Orders update successfully'
                        });
                        this.getWebOrders();
                        this.refreshPostOrderData();
                        this.$Progress.finish();

                    })
                    .catch((error)=>{

                        console.log("Batch Update processing status Error");
                        console.log(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });

                        this.getWebOrders();
                        this.refreshPostOrderData();
                        this.$Progress.failed();
                    });



            },


            genaratePDF(id){
               window.open(window.location.origin+"/invoice-genarte/"+id, '_blank');
            },



            updateOrderTest(event, id, order_id){
                console.log(event.target.value);
                console.log(id);
                console.log(order_id);
            },





        },
        mounted() {
           //
        },
        created() {
            this.$Progress.start();

            this.getPaymentMethod();
            this.getShipping();
            this.getOrderStatuses();
            this.getWebOrders();
            this.getOrderTotals();
            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
            filteredItems() {
                return this.autocompleteItems.filter(i => {
                    return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
                });
            },
            subTotal: function() {
                let total = 0;
                let data = this.productsData;
                $.each(data, function(key, value) {
                    total += value.price*value.quantity;
                });

                return total;
            },

            percentDiscount: function() {
                let total1 = 0;
                let subTotal1 = this.subTotal;
                total1 = subTotal1*this.pcntDiscount;
                total1 = total1/100;
                return total1;
            },
            filterOptions: function(){
                return this.options.filter(option => !option.stock_status.indexOf("instock"))
            },

            paymentDataPass(){
                this.postOrderData.payment_method = this.paymentData.method;
                this.postOrderData.payment_method_title = this.paymentData.pay_name;
            },
            shippingDataPass(){
                this.postOrderData.shipping_lines[0].method_id = this.shippingData;
                this.postOrderData.shipping_lines[0].method_title = this.shippingData;
            },

            productAdding(){
                if(this.productsData.length != 0){
                    console.log(this.productsData.length);
                    let perTotal = 0;
                    let productAdd = [];
                    perTotal = parseInt(this.percentDiscount)+parseInt(this.fixedDiscount);
                    perTotal = perTotal/this.productsData.length;

                    $.each(this.productsData, function(key, value){
                        let product = {
                            product_id: '',
                            quantity: '',
                            total: '',

                        };
                        let perTotal1 = 0;

                        perTotal1 = parseInt(value.price)*parseInt(value.quantity);
                        perTotal1 = perTotal1-perTotal;


                        product.product_id = value.id;
                        product.quantity = parseInt(value.quantity);
                        product.total = perTotal1.toString();

                        if(value.variation_id != 0){
                             Vue.set(product, 'variation_id', value.variation_id);
                        }

                          productAdd.push(product);
                    });

                   this.postOrderData.line_items = productAdd;
                }

            }

        },
    }
</script>

<style scoped>

.note_content {
    background: #d7cad2;
    padding: 10px;
    border-radius: 10px 10px 10px 0px;
    width: 300px;
}

 .header {
        position: sticky;
        top:0;
}

    .mytable {
        height: 600px;
        overflow: auto;
    }

    .my-white-space{
        white-space: nowrap;
    }


</style>
