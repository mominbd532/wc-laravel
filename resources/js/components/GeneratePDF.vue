<template>
    <div>

        <div id="testHtml">

            <table class="head container">
                <tr>
                    <td class="header">
                        <img src="#" alt="Shop Name" />
                    </td>
                    <td class="shop-info">
                        <div class="shop-name"><h3>Shop Name</h3></div>
                        <div class="shop-address"><p>Shop Address</p></div>
                    </td>
                </tr>
            </table>

            <h1 class="document-type-label">
                Invoice</h1>


            <table class="order-data-addresses">
                <tr>
                    <td class="address billing-address">
                        <div><h3>Billing Info:</h3></div>
                        <!-- <h3>Billing Address:</h3> -->
                        First Name Last Name<br/>
                        Address
                        <div class="billing-email">abc@#gmail.com</div>
                        <div class="billing-phone">+8801800000000</div>
                    </td>
                    <td class="address shipping-address">
                    </td>
                    <td class="order-data">
                        <table>

                            <tr class="order-number">
                                <th>Order Number:</th>
                                <td>145758}</td>
                            </tr>
                            <tr class="order-date">
                                <th>Order Date:</th>
                                <td>22.54522552</td>
                            </tr>
                            <tr class="payment-method">
                                <th>Payment Method:</th>
                                <td>COD</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table class="order-details">
                <thead>
                <tr>
                    <th class="sl">SL</th>
                    <th class="p_image">Image</th>
                    <th class="product">Product</th>
                    <th class="price">Price</th>
                    <th class="quantity">Quantity</th>
                    <th class="total">Total</th>
                </tr>
                </thead>
                <tbody>



                <tr class="1626">




                    <td class="sl">1</td>
                    <td class="p_image"><img width="100" height="100" src="3"  alt="" /></td>
                    <td class="product">
                        <span style="display: inline; position: relative; font-size: 14px;"><b>Product Name</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SKU: &nbsp;PAN001&nbsp;&nbsp;&nbsp;</span>

                    </td>

                    <td class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>20</bdi></span></td>
                    <td class="quantity">30</td>
                    <td class="total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>2000</bdi></span></td>
                </tr>

                </tbody>
                <tfoot>

                </tfoot>
            </table>
            <table class="dini_total">
                <tbody>
                <tr class="no-borders">
                    <td class="no-borders" style="width: 70%;">
                        <div class="customer-notes">


                            <img src="#" alt="pais" style="width: 200px;">





                        </div>

                    </td>

                    <td class="no-borders" style="width: 30%;" >
                        <table class="totals">
                            <tfoot>
                            <tr class="cart_subtotal">
                                <td class="no-borders"></td>
                                <th class="description">Subtotal</th>
                                <td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>

                             2000
						    </bdi></span></span></td>
                            </tr>
                            <tr class="shipping">
                                <td class="no-borders"></td>
                                <th class="description">Shipping</th>
                                <td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>2000</bdi></span>&nbsp;</span></td>
                            </tr>


                            <tr class="shipping">
                                <td class="no-borders"></td>
                                <th class="description">Discount</th>
                                <td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>30000</bdi></span>&nbsp;</span></td>
                            </tr>


                            <tr class="payment_method">
                                <td class="no-borders"></td>
                                <th class="description">Payment method</th>
                                <td class="prices"><span class="totals-price">Cash on delivery</span></td>
                            </tr>
                            <tr class="order_total">
                                <td class="no-borders"></td>
                                <th class="description">Grand Total</th>
                                <td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>5600</bdi></span></span></td>
                            </tr>



                            <tr class="shipping">
                                <td class="no-borders"></td>
                                <th class="description">Paid</th>
                                <td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>20024</bdi></span>&nbsp;</span></td>
                            </tr>

                            <tr class="order_total">
                                <td class="no-borders"></td>
                                <th class="description">Due</th>
                                <td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>0</bdi></span></span></td>
                            </tr>



                            </tfoot>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="bottom-spacer"></div>




            <div id="footer">

            </div><!-- #letter-footer -->


        </div>

        <div>
            <button class="btn btn-secondary ml-5"  @click="generatePdf('testHtml')">Print</button>
        </div>
    </div>



</template>

<script>


export default {
    name: "GeneratePDF.vue",

    components: {

    },

    data (){
        return {
            htmlToPdfOptions: {
                margin: 0
            }
        }
    },

    methods: {
        /*
            Generate Report using refs and calling the
            refs function generatePdf()
        */

        generatePdf(divName){
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

    },
}
</script>

<style scoped>

</style>
