<?php

use Automattic\WooCommerce\Client;
$my_site_url = env('MIX_WC_URL');
$my_site_ck = env('MIX_WC_CONSUMER_KEY');
$my_site_cs = env('MIX_WC_CONSUMER_SECRET');
$my_site_version = env('MIX_WC_VERSION');
         $woocommerce = new Client(
             $my_site_url,
             $my_site_ck,
             $my_site_cs,
			 [
			     'wp_api' => true,
				 'version' => $my_site_version
			 ]
		 );

         $order =$woocommerce->get('orders/'.$id);


 ?>



@extends('layouts.pdf-layout')

@section('content')



<table class="head container">
	<tr>
		<td class="header">
		<img src="{{asset('logo1.png')}}" alt="{{env('APP_NAME')}}" />
	    </td>
		<td class="shop-info">
			<div class="shop-name"><h3>{{env('MY_SHOP_TITLE')}}</h3></div>
			<div class="shop-address"><p>{{env('MY_SHOP_ADDRESS')}}</p></div>
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
						{{$order->billing->first_name}}&nbsp;{{$order->billing->last_name}}<br/>
						{{$order->billing->address_1}}&nbsp;{{$order->billing->city}}&nbsp;{{$order->billing->state}}&nbsp;{{$order->billing->postcode}}
						<div class="billing-email">{{$order->billing->email}}</div>
						<div class="billing-phone">{{$order->billing->phone}}</div>
					</td>
		<td class="address shipping-address">
					</td>
		<td class="order-data">
			<table>
				<tr class="invoice-number">
					<th>Invoice Number:</th>
					<td>
						@foreach($order->meta_data as $meta_info)
						@if($meta_info->key == "_wcpdf_invoice_number")
						<b>{{$meta_info->value}}</b>
						@endif
						@endforeach
					</td>
				</tr>
				<tr class="invoice-date">
					<th>Invoice Date:</th>
					<td>
                       @foreach($order->meta_data as $meta_info)
						@if($meta_info->key == "_wcpdf_invoice_date_formatted")
						{{date("d-M-Y", strtotime($meta_info->value))}}
						@endif
						@endforeach
					</td>
				</tr>
				<tr class="order-number">
					<th>Order Number:</th>
					<td>{{$order->id}}</td>
				</tr>
				<tr class="order-date">
					<th>Order Date:</th>
					<td>{{date("d-M-Y", strtotime($order->date_created))}}</td>
				</tr>
				<tr class="payment-method">
					<th>Payment Method:</th>
					<td>{{$order->payment_method_title}}</td>
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

		<?php $subTotal = 0;?>
		@foreach($order->line_items as $key=>$item)

		    <tr class="1626">

		    	<?php
		    	if($item->variation_id > 0){
		    		$product =$woocommerce->get('products/'.$item->variation_id);
		    	}else{
		    		$product =$woocommerce->get('products/'.$item->product_id);
		    	}
		    	 ?>


            <td class="sl">{{$key+1}}</td>
            <td class="p_image"><img width="100" height="100" src="{{$product->images[0]->src}}"  alt="" /></td>
			<td class="product">
								<span style="display: inline; position: relative; font-size: 14px;"><b>{{$item->name}}</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SKU: &nbsp;{{$item->sku}}&nbsp;&nbsp;&nbsp;</span>
                               {{-- Publication: Darussalam Publishers --}}

            </td>

            <td class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>{{$item->subtotal/$item->quantity}}</bdi></span></td>
            <td class="quantity">{{$item->quantity}}</td>
			<td class="total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>{{$item->subtotal}}</bdi></span></td>
		     </tr>

		     <?php $subTotal = $subTotal+$item->subtotal;?>



		     @endforeach





			</tbody>
	<tfoot>

	</tfoot>
</table>
<table class="dini_total">
	<tbody>
	<tr class="no-borders">
			<td class="no-borders" style="width: 70%;">
				<div class="customer-notes">

					@if($order->status == "confirmed" && $order->payment_method_title != "Cash on delivery")
					<img src="{{asset('/images/invoice/paid.png')}}" alt="pais" style="width: 200px;">
					@endif




				</div>

             </td>

			<td class="no-borders" style="width: 30%;" >
				<table class="totals">
					<tfoot>
												<tr class="cart_subtotal">
							<td class="no-borders"></td>
							<th class="description">Subtotal</th>
							<td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>

                             {{$subTotal}}
						    </bdi></span></span></td>
						</tr>
						<tr class="shipping">
							<td class="no-borders"></td>
							<th class="description">Shipping</th>
							<td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>{{$order->shipping_total}}</bdi></span>&nbsp;</span></td>
						</tr>
						@if($order->discount_total > 0)

						<tr class="shipping">
							<td class="no-borders"></td>
							<th class="description">Discount</th>
							<td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>{{$order->discount_total}}</bdi></span>&nbsp;</span></td>
						</tr>
						@endif

						<tr class="payment_method">
							<td class="no-borders"></td>
							<th class="description">Payment method</th>
							<td class="prices"><span class="totals-price">Cash on delivery</span></td>
						</tr>
						<tr class="order_total">
							<td class="no-borders"></td>
							<th class="description">Grand Total</th>
							<td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>{{$subTotal + $order->shipping_total - $order->discount_total}}</bdi></span></span></td>
						</tr>

						@if($order->status == "confirmed" && $order->payment_method_title != "Cash on delivery")

						<tr class="shipping">
							<td class="no-borders"></td>
							<th class="description">Paid</th>
							<td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>{{$subTotal + $order->shipping_total - $order->discount_total}}</bdi></span>&nbsp;</span></td>
						</tr>

						<tr class="order_total">
							<td class="no-borders"></td>
							<th class="description">Due</th>
							<td class="prices"><span class="totals-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#2547;&nbsp;</span>0</bdi></span></span></td>
						</tr>

						@endif

						</tfoot>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<div class="bottom-spacer"></div>




<div id="footer">

</div><!-- #letter-footer -->



@endsection

