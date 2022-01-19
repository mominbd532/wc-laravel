<template>
    <section class="content">
        <div class="container-fluid">
            <div v-if="list_shown" class="row ">

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-sign-language"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[1].name}}</span>
                            <span class="info-box-number">{{orders_total[1].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-pause-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[2].name}}</span>
                            <span class="info-box-number">{{orders_total[2].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[3].name}}</span>
                            <span class="info-box-number">{{orders_total[3].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-truck"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[4].name}}</span>
                            <span class="info-box-number">{{orders_total[4].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon elevation-1" style="background: #a142f5; color: #fff;" ><i class="fas fa-truck-loading"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[5].name}}</span>
                            <span class="info-box-number">{{orders_total[5].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon elevation-1" style="background: #FFA500; color: #fff;"><i class="fas fa-undo"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[6].name}}</span>
                            <span class="info-box-number">{{orders_total[6].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file-archive"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[7].name}}</span>
                            <span class="info-box-number">{{orders_total[7].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-window-close"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[8].name}}</span>
                            <span class="info-box-number">{{orders_total[8].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon elevation-1" style="background: #4B3869; color: #fff;"><i class="fas fa-hand-holding-usd"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[9].name}}</span>
                            <span class="info-box-number">{{orders_total[9].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon elevation-1" style="background: #5D8233; color: #fff;"><i class="fas fa-stop"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[10].name}}</span>
                            <span class="info-box-number">{{orders_total[10].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon elevation-1" style="background: #F2789F; color: #fff;"><i class="fas fa-money-bill-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{orders_total[0].name}}</span>
                            <span class="info-box-number">{{orders_total[0].total}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->



            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Left col -->
                <!--<div class="col-md-8">-->
                    <!--&lt;!&ndash; MAP & BOX PANE &ndash;&gt;-->
                    <!--<div class="card">-->
                    <!--<div class="card-header">-->
                        <!--<h3 class="card-title">Latest Orders (Demo)</h3>-->

                        <!--<div class="card-tools">-->
                        <!--<button type="button" class="btn btn-tool" data-card-widget="collapse">-->
                            <!--<i class="fas fa-minus"></i>-->
                        <!--</button>-->
                        <!--<button type="button" class="btn btn-tool" data-card-widget="remove">-->
                            <!--<i class="fas fa-times"></i>-->
                        <!--</button>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--&lt;!&ndash; /.card-header &ndash;&gt;-->
                    <!--<div class="card-body p-0">-->
                        <!--<div class="table-responsive">-->
                        <!--<table class="table m-0">-->
                            <!--<thead>-->
                                <!--<tr>-->
                                    <!--<th>Order ID</th>-->
                                    <!--<th>Item</th>-->
                                    <!--<th>Status</th>-->
                                    <!--<th>Popularity</th>-->
                                <!--</tr>-->
                            <!--</thead>-->
                            <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td><a href="pages/examples/invoice.html">OR9842</a></td>-->
                                    <!--<td>Call of Duty IV</td>-->
                                    <!--<td><span class="badge badge-success">Shipped</span></td>-->
                                    <!--<td>-->
                                        <!--<div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td><a href="pages/examples/invoice.html">OR1848</a></td>-->
                                    <!--<td>Samsung Smart TV</td>-->
                                    <!--<td><span class="badge badge-warning">Pending</span></td>-->
                                    <!--<td>-->
                                        <!--<div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td><a href="pages/examples/invoice.html">OR7429</a></td>-->
                                    <!--<td>iPhone 6 Plus</td>-->
                                    <!--<td><span class="badge badge-danger">Delivered</span></td>-->
                                    <!--<td>-->
                                        <!--<div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td><a href="pages/examples/invoice.html">OR7429</a></td>-->
                                    <!--<td>Samsung Smart TV</td>-->
                                    <!--<td><span class="badge badge-info">Processing</span></td>-->
                                    <!--<td>-->
                                        <!--<div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td><a href="pages/examples/invoice.html">OR1848</a></td>-->
                                    <!--<td>Samsung Smart TV</td>-->
                                    <!--<td><span class="badge badge-warning">Pending</span></td>-->
                                    <!--<td>-->
                                        <!--<div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td><a href="pages/examples/invoice.html">OR7429</a></td>-->
                                    <!--<td>iPhone 6 Plus</td>-->
                                    <!--<td><span class="badge badge-danger">Delivered</span></td>-->
                                    <!--<td>-->
                                        <!--<div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>-->
                                    <!--</td>-->
                                <!--</tr>-->
                            <!--</tbody>-->
                        <!--</table>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--&lt;!&ndash; /.card-body &ndash;&gt;-->
                <!--</div>-->
                <!--&lt;!&ndash; /.card &ndash;&gt;-->
                <!--&lt;!&ndash; /.card &ndash;&gt;-->
            <!--</div>-->
            <!-- /.col -->

            <!--<div class="col-md-4">-->
                <!--&lt;!&ndash; Info Boxes Style 2 &ndash;&gt;-->
                <!--<div class="info-box mb-3 bg-secondary">-->
                <!--<span class="info-box-icon"><i class="fas fa-tag"></i></span>-->

                <!--<div class="info-box-content">-->
                    <!--<span class="info-box-text">Inventory</span>-->
                    <!--<span class="info-box-number">5,200</span>-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
                <!--<div class="info-box mb-3 bg-success">-->
                <!--<span class="info-box-icon"><i class="far fa-heart"></i></span>-->

                <!--<div class="info-box-content">-->
                    <!--<span class="info-box-text">Mentions</span>-->
                    <!--<span class="info-box-number">92,050</span>-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
                <!--<div class="info-box mb-3 bg-danger">-->
                <!--<span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>-->

                <!--<div class="info-box-content">-->
                    <!--<span class="info-box-text">Downloads</span>-->
                    <!--<span class="info-box-number">114,381</span>-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
                <!--<div class="info-box mb-3 bg-info">-->
                <!--<span class="info-box-icon"><i class="far fa-comment"></i></span>-->

                <!--<div class="info-box-content">-->
                    <!--<span class="info-box-text">Direct Messages</span>-->
                    <!--<span class="info-box-number">163,921</span>-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
                <!--</div>-->
                <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
            <!--</div>-->
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
</template>

<script>
    export default {

        data (){
            return {
                   orders_total: [],
                   list_shown: false,
            }
        },

        methods: {
            getOrderTotals(){
                diniApi.get("reports/orders/totals")
                    .then((response) => {
                        this.orders_total = response.data;
                        this.list_shown = true;
                        document.getElementById('count-processing').innerHTML = this.orders_total[1].total;
                        document.getElementById('count-on-hold').innerHTML = this.orders_total[2].total;
                        document.getElementById('count-confirmed').innerHTML = this.orders_total[3].total;
                        document.getElementById('count-in-transit').innerHTML = this.orders_total[4].total;
                        document.getElementById('count-delivered').innerHTML = this.orders_total[5].total;
                        document.getElementById('count-returned').innerHTML = this.orders_total[6].total;
                        document.getElementById('count-completed').innerHTML = this.orders_total[7].total;
                        document.getElementById('count-cancelled').innerHTML = this.orders_total[8].total;
                        document.getElementById('count-refunded').innerHTML = this.orders_total[9].total;
                        document.getElementById('count-failed').innerHTML = this.orders_total[10].total;
                        document.getElementById('count-pending').innerHTML = this.orders_total[0].total;
                    })
                    .catch((error) => {
                      console.log(error);
                    })
            }
        },
        mounted() {
            this.getOrderTotals();
        },
        created() {
            this.$Progress.start();

            this.$Progress.finish();
        },
    }
</script>
