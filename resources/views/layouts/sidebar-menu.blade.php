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

$reports =$woocommerce->get('reports/orders/totals');

?>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      {{--<li class="nav-item">--}}
        {{--<router-link to="/products" class="nav-link">--}}
          {{--<i class="nav-icon fas fa-list orange"></i>--}}
          {{--<p>--}}
            {{--Product--}}
          {{--</p>--}}
        {{--</router-link>--}}
      {{--</li>--}}


        <li class="nav-item">
            <router-link to="/web-orders" class="nav-link">
                <i class="nav-icon fas fa-list orange"></i>
                <p>
                   All Order
                </p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/processing-orders" class="nav-link">
                <i class="nav-icon fas fa-sign-language blue"></i>
                <p>
                   Processing Order
                </p>

                <span class="rounded bg-danger pl-1 pr-1">{{$reports[1]->total}}</span>
            </router-link>
        </li>



        <li class="nav-item">
            <router-link to="/on-hold-orders" class="nav-link">
                <i class="nav-icon fas fa-pause-circle yellow"></i>
                <p>
                    On hold Order
                </p>

                <span class="rounded bg-danger pl-1 pr-1">{{$reports[2]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/confirmed-orders" class="nav-link">
                <i class="nav-icon fas fa-check-circle green"></i>
                <p>
                    Confirmed Order
                </p>

                <span class="rounded bg-danger pl-1 pr-1">{{$reports[3]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/in-transit-orders" class="nav-link">
                <i class="nav-icon fas fas fa-truck white"></i>
                <p>
                    In-Transit Order
                </p>
                <span class="rounded bg-danger pl-1 pr-1">{{$reports[4]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/delivered-orders" class="nav-link">
                <i class="nav-icon fas fa-truck-loading" style="color: #a142f5;"></i>
                <p>
                    Delivered Order
                </p>
                <span class="rounded bg-danger pl-1 pr-1">{{$reports[5]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/returned-orders" class="nav-link">
                <i class="nav-icon fas fa-undo orange"></i>
                <p>
                    Returned Order
                </p>
                <span class="rounded bg-danger pl-1 pr-1">{{$reports[6]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/completed-orders" class="nav-link">
                <i class="nav-icon fas fa-file-archive blue"></i>
                <p>
                    Completed Order
                </p>
                <span class="rounded bg-danger pl-1 pr-1">{{$reports[7]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/cancelled-orders" class="nav-link">
                <i class="nav-icon fas fa-window-close red"></i>
                <p>
                    Cancelled Order
                </p>
                <span class="rounded bg-danger pl-1 pr-1">{{$reports[8]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/refunded-orders" class="nav-link">
                <i class="nav-icon fas fa-hand-holding-usd" style="color: #4B3869;"></i>
                <p>
                    Refunded Order
                </p>
                <span class="rounded bg-danger pl-1 pr-1">{{$reports[9]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/failed-orders" class="nav-link">
                <i class="nav-icon fas fa-stop" style="color: #5D8233;"></i>
                <p>
                    Failed Order
                </p>
                <span class="rounded bg-danger pl-1 pr-1">{{$reports[10]->total}}</span>
            </router-link>
        </li>



        <li class="nav-item">
            <router-link to="/pending-payment-orders" class="nav-link">
                <i class="nav-icon fas fa-money-bill-alt pink"></i>
                <p>
                    Pending Pay Order
                </p>

                <span class="rounded bg-danger pl-1 pr-1">{{$reports[0]->total}}</span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/orders" class="nav-link">
                <i class="nav-icon fas fa-list orange"></i>
                <p>
                    Local Order
                </p>
            </router-link>
        </li>







        {{--<li class="nav-item">--}}
            {{--<router-link to="/reports" class="nav-link">--}}
                {{--<i class="nav-icon fas fa-list orange"></i>--}}
                {{--<p>--}}
                    {{--Reports--}}
                {{--</p>--}}
            {{--</router-link>--}}
        {{--</li>--}}


    @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Users</p>
          </router-link>
        </li>
      @endcan



      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          {{--<li class="nav-item">--}}
            {{--<router-link to="/product/category" class="nav-link">--}}
              {{--<i class="nav-icon fas fa-list-ol green"></i>--}}
              {{--<p>--}}
                {{--Category--}}
              {{--</p>--}}
            {{--</router-link>--}}
          {{--</li>--}}
            <li class="nav-item">
                <router-link to="/payment-methods" class="nav-link">
                    <i class="nav-icon fas fa-list-ol green"></i>
                    <p>
                        Payment Methods
                    </p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/shipping-titles" class="nav-link">
                    <i class="nav-icon fas fa-list-ol green"></i>
                    <p>
                        Shipping Titles
                    </p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/shop-setting" class="nav-link">
                    <i class="nav-icon fas fa-list-ol green"></i>
                    <p>
                        Shop Setting
                    </p>
                </router-link>
            </li>

            <li class="nav-item">
                <router-link to="/generate-pdf" class="nav-link">
                    <i class="nav-icon fas fa-list-ol green"></i>
                    <p>
                        Generate PDf
                    </p>
                </router-link>
            </li>
          {{--<li class="nav-item">--}}
            {{--<router-link to="/product/tag" class="nav-link">--}}
              {{--<i class="nav-icon fas fa-tags green"></i>--}}
              {{--<p>--}}
                {{--Tags--}}
              {{--</p>--}}
            {{--</router-link>--}}
          {{--</li>--}}

            {{--<li class="nav-item">--}}
              {{--<router-link to="/developer" class="nav-link">--}}
                  {{--<i class="nav-icon fas fa-cogs white"></i>--}}
                  {{--<p>--}}
                      {{--Developer--}}
                  {{--</p>--}}
              {{--</router-link>--}}
            {{--</li>--}}
        </ul>
      </li>

      @endcan



      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>
