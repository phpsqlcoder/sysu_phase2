@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/datatables/Responsive-2.2.3/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
@php
    $modals='';
@endphp
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
</div>
<span onclick="closeNav()" class="dark-curtain"></span>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div id="col1" class="col-lg-3">  
                <nav class="rd-navbar rd-navbar-listing">
                    <div class="listing-filter-wrap">
                        <div class="rd-navbar-listing-close-toggle rd-navbar-static--hidden toggle-original"><span class="lnr lnr-cross"></span> Close</div>
                        <h3 class="subpage-heading">Options</h3>
                        @include('theme.sysu.layout.sidebar-menu')
                    </div>
                </nav>
            </div>
            <div id="col2" class="col-lg-9">
                <nav class="rd-navbar">
                    <div class="rd-navbar-listing-toggle rd-navbar-static--hidden toggle-original" data-rd-navbar-toggle=".listing-filter-wrap"><span class="lnr lnr-list"></span> Options</div>
                </nav>
                <h3 class="catalog-title">Transaction History</h3>
                
                @if(isset($_GET['order_cancelled']))                        
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Important Notice:</h4>
                        <p>The payment transaction you processed was unsuccessful.</p>
                        <hr>
                        <p class="mb-0">If you wish to continue with your order, please click on the corresponding Pay icon <i class="fa fa-credit-card"></i> of Order#: <i style="font-weight:bold;">{{$_GET['order_no']}}</i></p>
                    </div>
                @endif
                <div class="table-history" style="overflow-x:auto;">

                    <table id="salesTransaction" class="table table-hover small text-center overflow-auto">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle">Order#</th>
                                <th scope="col" class="align-middle">Date</th>
                                <th scope="col" class="align-middle">Amount</th>
                                <!-- <th scope="col" class="align-middle">Paid</th>
                                <th scope="col" class="align-middle">Balance</th> -->
                                <th scope="col" class="align-middle">Delivery Status</th>
                                <th scope="col" class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                                @php
                                $paid = \App\EcommerceModel\SalesHeader::paid($sale->id);
                                $balance = \App\EcommerceModel\SalesHeader::balance($sale->id);
                                $btn = '';
                                @endphp
                                <tr>
                                    <td>{{$sale->order_number}}</td>
                                    <td>{{$sale->created_at}}</td>
                                    <td>{{number_format($sale->gross_amount,2)}}</td>
                                    <!-- <td>{{number_format($paid,2)}}</td>
                                    <td>{{number_format($balance,2)}}</td> -->
                                    <td>{{$sale->delivery_status}}</td>
                                    <td align="right">
                                        @if($sale->status != 'CANCELLED')
                                            <a href="#" title="View Items" data-toggle="modal" data-target="#detail{{$sale->id}}" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>
                                            @if ($balance > 0)
                                                <a href="{{route('my-account.pay-again',$sale->id)}}" title="Pay Now" class="btn btn-success btn-sm mb-1"><i class="fa fa-credit-card pb-1"></i></a>&nbsp;
                                            @endif
                                            @if($paid <= 0)                                            
                                                <a href="#" title="Cancel Order" onclick="cancel_unpaid_order('{{$sale->order_number}}')" class="btn btn-danger btn-sm mb-1"><i class="fa fa-times pb-1"></i></a>&nbsp;
                                            @else
                                                <a target="_blank" href="https://forms.office.com/Pages/ResponsePage.aspx?id=XEGiMjf44Uyvp90T9OPGD8Ao7kIPdnhJk-AhXKYQL4JUQkRFMUo0MEEwS0ZDR0hHRFI0NEFVQTVTQy4u" title="Cancel Order" class="btn btn-danger btn-sm mb-1"><i class="fa fa-times pb-1"></i></a>&nbsp;
                                            @endif
                                            
                                            <a href="#" title="View Delivery History" class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#delivery{{$sale->id}}"><i class="fa fa-truck pb-1"></i></a>

                                            @if($sale->delivery_status == 'Delivered')
                                                <a href="#" title="Reorder Items" data-toggle="modal" data-target="#reorder_products{{$sale->id}}" class="btn btn-success btn-sm mb-1"><i class="fa fa-shopping-cart pb-1"></i></a>

                                                <!-- <a href="#" title="Reorder" class="btn btn-success btn-sm mb-1" onclick="reorder('{{$sale->id}}')"><i class="fa fa-shopping-cart pb-1"></i></a> -->    
                                            @endif
                                        @else
                                            <a href="#" title="View Items" data-toggle="modal" data-target="#detail{{$sale->id}}" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @php

                                    $modals .='  
                                        <div class="modal fade" id="delivery'.$sale->id.'" tabindex="-1" role="dialog" aria-labelledby="trackModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="trackModalLabel">'.$sale->order_number.'</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="transaction-status">
                                                        </div>
                                                        <div class="gap-20"></div>
                                                        <div class="table-modal-wrap">
                                                            <table class="table table-md table-modal">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date and Time</th>
                                                                        <th>Status</th>
                                                                        <th>Remarks</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                                                                    if($sale->deliveries){
                                                                        foreach($sale->deliveries as $delivery){
                                                                         $modals.='
                                                                            <tr>
                                                                                <td>'.$delivery->created_at.'</td>
                                                                                <td>'.$delivery->status.'</td>
                                                                                <td>'.$delivery->remarks.'</td>
                                                                            </tr>
                                                                        ';
                                                                        }
                                                                    }
                                                                $modals .='
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="gap-20"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="detail'.$sale->id.'" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel">'.$sale->order_number.'</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="transaction-status">
                                                            <p>Date: '.$sale->created_at.'</p>
                                                            <p>Payment Status: '.$sale->payment_status.'</p>
                                                        </div>
                                                        <div class="gap-20"></div>
                                                        <div class="table-modal-wrap">
                                                            <table class="table table-md table-modal" style="font-size:12px !important;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product Code</th>
                                                                        <th>Description</th>
                                                                        <th>Qty</th>
                                                                        <th>Price</th>
                                                                        <th class="text-right">Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';

                                                                        $total_qty = 0;
                                                                        $total_sales = 0;

                                                                    foreach($sale->items as $item){

                                                                        $total_qty += $item->qty;
                                                                        $total_sales += $item->qty * $item->price;
                                                                        $modals.='
                                                                        <tr>
                                                                            <td>'.$item->product_id.'</td>
                                                                            <td>'.$item->product_name.'</td>
                                                                            <td>'.$item->qty.' '.$item->uom.'</td>
                                                                            <td>'.number_format($item->price,2).'</td>
                                                                            <td class="text-right">'.number_format(($item->price * $item->qty),2).'</td>
                                                                        </tr>';
                                                                    }

                                                                    $delivery_discount = \App\EcommerceModel\CouponSale::total_discount_delivery($sale->id);

                                                                    $modals.='
                                                                    <tr style="font-weight:bold;">
                                                                        <td colspan="2">Sub total</td>
                                                                        <td>'.number_format($total_qty,2).'</td>
                                                                        <td>&nbsp;</td>
                                                                        <td class="text-right">'.number_format($total_sales,2).'</td>
                                                                    </tr>
                                                                    
                                                                    <tr style="font-weight:bold;">
                                                                        <td colspan="4">Coupon Discount</td>
                                                                        <td class="text-right">- '.number_format($sale->discount_amount,2).'</td>
                                                                    </tr>

                                                                    <tr style="font-weight:bold;">
                                                                        <td colspan="4">Delivery Fee</td>                                 
                                                                        <td class="text-right">'.number_format($sale->delivery_fee_amount,2).'</td>
                                                                    </tr>

                                                                    <tr style="font-weight:bold;">
                                                                        <td colspan="4">Delivery Discount</td>                                 
                                                                        <td class="text-right">- '.number_format($delivery_discount,2).'</td>
                                                                    </tr>


                                                                    <tr style="font-weight:bold;">
                                                                        <td colspan="4">Grand total</td>
                                                                       
                                                                        <td class="text-right">'.number_format(($total_sales-$sale->discount_amount)+($sale->delivery_fee_amount-$delivery_discount),2).'</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="gap-20"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="reorder_products'.$sale->id.'" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel">'.$sale->order_number.'</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <div class="gap-20"></div>
                                                        <div class="table-modal-wrap">
                                                            <table class="table table-md table-modal" style="font-size:12px !important;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>&nbsp;</th>
                                                                        <th>Description</th>
                                                                        <th>Qty</th>
                                                                        <th>Price</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';

                                                                        $total_qty = 0;
                                                                        $total_sales = 0;
                                                                        $btn = '';
                                                                        $is_fav = '';
                                                                        $display = '';

                                                                    foreach($sale->items as $item){
                                                                        $is_fav = \App\EcommerceModel\CustomerWishlist::is_wishlist($item->product_id);
                                                                        if($item->product->maxpurchase > 0){
                                                                            $total_qty += $item->qty;
                                                                            $total_sales += $item->qty * $item->price;

                                                                            $btn = '<input checked type="checkbox" onchange="cb('.$sale->id.','.$item->product_id.');" class="cb'.$sale->id.'" id="cb'.$sale->id.'_'.$item->product_id.'">';
                                                                        } else {
                                                                            if($is_fav == 0){
                                                                                $btn = '<a style="display: none;" id="wishrmv" href="#" onclick="remove_to_wishlist('.$item->product_id.')">Remove to Wishlist</a>
                                                                                        <a style="display: block;" id="wishadd" href="#" onclick="add_to_wishlist('.$item->product_id.')">Add to Wishlist</a>';
                                                                            } else {
                                                                                $btn = '<a style="display: block;" id="wishrmv" href="#" onclick="remove_to_wishlist('.$item->product_id.')">Remove to Wishlist</a>
                                                                                        <a style="display: none;" id="wishadd" href="#" onclick="add_to_wishlist('.$item->product_id.')">Add to Wishlist</a>';
                                                                            }
                                                                            
                                                                        }

                                                                        $modals.='
                                                                        <tr>
                                                                            <td>
                                                                                '.$btn.'
                                                                            </td>
                                                                            <td>'.$item->product_name.'</td>
                                                                            <td>
                                                                                <input type="number" class="form-control sale'.$sale->id.'_product_totalqty" value="'.number_format($item->qty,0).'" min="1" id="sale'.$sale->id.'_product'.$item->product_id.'_qty" onchange="reorder_qty('.$sale->id.','.$item->product_id.')">
                                                                            </td>
                                                                            <td>
                                                                                '.number_format($item->product->price,2).'
                                                                                <input type="hidden" id="sale'.$sale->id.'_product'.$item->product_id.'_price" value="'.number_format($item->product->price,2).'">
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="sale'.$sale->id.'_product_totalprice"  id="sale'.$sale->id.'_product'.$item->product_id.'_totalprice" value="'.number_format(($item->product->price * $item->qty),2).'">
                                                                                <span id="sale'.$sale->id.'_product'.$item->product_id.'_span">'.number_format(($item->product->price * $item->qty),2).'</span>
                                                                            </td>
                                                                        </tr>';
                                                                    }
                                                                    $modals.='
                                                                     <tr style="font-weight:bold;">
                                                                        <td colspan="2">Sub total</td>
                                                                        <td>
                                                                            <input type="hidden" id="input_sale'.$sale->id.'_totalqty" value="'.number_format($total_qty,2).'">
                                                                            <span id="sale'.$sale->id.'_totalqty">'.number_format($total_qty,2).'</span>
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                        <td>
                                                                            <input type="hidden" id="input_sale'.$sale->id.'_subtotal" value="'.number_format($total_sales,2).'">
                                                                            <span id="sale'.$sale->id.'_subtotal">'.number_format($total_sales,2).'</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="gap-20"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" onclick="reorder('.$sale->id.');">Reorder</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                                @endphp
                            @empty
                                <td>
                                    <div class="alert alert-warning" role="alert">
                                        No Record found
                                    </div>
                                </td>
                            @endforelse

                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="products" name="products">
        <input type="text" id="qty" name="qty">
    </form>

</section>
<div class="modal fade" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="cancel_orderid" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('my-account.cancel-order')}}" method="post">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="cancel_orderid"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this order?</p>
                <input type="hidden" id="order_number" name="order_number">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input class="btn btn-success" type="submit" value="Continue">
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="payment_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="ePayment" id="ePayment" action="https://sandbox.ipay88.com.ph/epayment/entry.asp" method="post">
                    <div class="form-group">
                        <label for="Amount" class="col-form-label">Amount to Pay:</label>
                        <input type="number" min="0.00" step="0.01" class="form-control" id="Amount2" name="Amount2">
                    </div>
                    <input type="hidden" name="merchantcode" id="merchantcode" value="PH00125">
                    <input type="hidden" name="paymentid" id="paymentid" value="1">
                    <input type="hidden" name="RefNo" id="RefNo">
                    <input type="hidden" name="Amount" id="Amount">
                    <input type="hidden" name="Currency" id="Currency" value="PHP">
                    <input type="hidden" name="Remark" id="Remark" value="Lydias Lechon Payment">
                    <input type="hidden" name="ProdDesc" id="ProdDesc" value="Lydias Lechon Payment">
                    <input type="hidden" name="UserName" id="UserName" value="{{Auth::user()->email}}">
                    <input type="hidden" name="UserEmail" id="UserEmail" value="{{Auth::user()->email}}">
                    <input type="hidden" name="UserContact" id="UserContact" value="">
                    <input type="hidden" name="ResponseURL" value="https://beta.lydias-lechon.com/ipay_processor.php">
                    <input type="hidden" name="BackendURL" value="https://beta.lydias-lechon.com/ipay_backend.php">
                    <input type="hidden" name="signature" id="signature" value="">                                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="javascript:void(0)" onclick="paying();" class="btn btn-primary">Pay Now</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_reorder" tabindex="-1" role="dialog" aria-labelledby="reorder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('my-account.reorder')}}" method="post">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reorder this transaction?</p>
                <input type="hidden" id="orderid" name="orderid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input class="btn btn-success" type="submit" value="Yes, Reorder">
            </div>
            </form>
        </div>
    </div>
</div>

{!!$modals!!}
@endsection

@section('pagejs')
    <script src="{{ asset('theme/sysu/plugins/datatables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        /*** Handles the Select All Checkbox ***/
        function checkbox_all(saleid){
            var status = $('#ckbox'+saleid).is(":checked") ? true : false;
            $('.cb'+saleid).prop("checked",status);
        }

        function reorder_qty(saleid,productid){
            var qty = $('#sale'+saleid+'_product'+productid+'_qty').val();
            var price = $('#sale'+saleid+'_product'+productid+'_price').val();
            var total_price = parseFloat(price)*parseInt(qty);

            $('#sale'+saleid+'_product'+productid+'_span').html(total_price.toFixed(2));
            $('#sale'+saleid+'_product'+productid+'_totalprice').val(total_price.toFixed(2));

            subtotal(saleid);
        }

        function subtotal(sid){
            var subtotal = 0;
            $('.sale'+sid+'_product_totalprice').each(function() {
                if(!isNaN(this.value) && this.value.length!=0) {
                    subtotal += parseFloat(this.value); 
                }
            });

            var totalqty = 0;
            $('.sale'+sid+'_product_totalqty').each(function() {
                if(!isNaN(this.value) && this.value.length!=0) {
                    totalqty += parseInt(this.value);
                }
            });
            
            $('#input_sale'+sid+'_totalqty').val(totalqty.toFixed(2));
            $('#input_sale'+sid+'_subtotal').val(subtotal.toFixed(2));
            $('#sale'+sid+'_subtotal').html(subtotal.toFixed(2));
            $('#sale'+sid+'_totalqty').html(totalqty.toFixed(2));
        }

        function reorder(saleid){
            var counter = 0;
            var selected_products = '';
            var product_qty = '';

            $('.cb'+saleid+':checked').each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_products += fid.substring(2, fid.length)+'|';
                product_qty += $('#sale'+saleid+'_product'+fid.substring(2, fid.length)+'_qty').val()+'|';
            });

            if(parseInt(counter) < 1){
                swal({
                    title: '',
                    text: "Please select at least one (1) product.",         
                });
                return false;
            }
            else{
                post_form("{{route('profile.sales-reorder-product')}}",selected_products,product_qty);
            }
        }

        function cb(sid,pid){
            var subtotal = $('#input_sale'+sid+'_subtotal').val();
            var totalqty = $('#input_sale'+sid+'_totalqty').val();

            var product_tqty   = $('#sale'+sid+'_product'+pid+'_qty').val();
            var product_tprice = $('#sale'+sid+'_product'+pid+'_totalprice').val();

            if($('#cb'+sid+'_'+pid).is(':checked')) {
                var total = parseFloat(subtotal)+parseFloat(product_tprice);
                var qty   = parseFloat(totalqty)+parseFloat(product_tqty);
            } else {
                var total = parseFloat(subtotal)-parseFloat(product_tprice);
                var qty   = parseFloat(totalqty)-parseFloat(product_tqty);
            }


            $('#input_sale'+sid+'_subtotal').val(total.toFixed(2));
            $('#sale'+sid+'_subtotal').html(total.toFixed(2));  

            $('#input_sale'+sid+'_totalqty').val(qty.toFixed(2));
            $('#sale'+sid+'_totalqty').html(qty.toFixed(2));  
        }

        function post_form(url,products,qty){
            $('#posting_form').attr('action',url);
            $('#products').val(products);
            $('#qty').val(qty);
            $('#posting_form').submit();
        }

        function add_to_wishlist(product_id){
            $.ajax({
                data: {
                    "product_id": product_id,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('add-to-wishlist')}}",
                success: function(returnData) {
                    if (returnData['success']) {
                        $('#wishrmv').css('display','block');
                        $('#wishadd').css('display','none');

                        swal({
                            title: '',
                            text: "Product has been added to wishlist.",         
                        });
                    }
                }
            });
        }

        function remove_to_wishlist(product_id){
            $.ajax({
                data: {
                    "product_id": product_id,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('remove-to-wishlist')}}",
                success: function(returnData) {
                    if (returnData['success']) {
                        $('#wishrmv').css('display','none');
                        $('#wishadd').css('display','block');

                        swal({
                            title: '',
                            text: "Product has been removed to wishlit.",         
                        });
                    }
                }
            });
        }

        $(document).ready(function () {
            $('#salesTransaction').DataTable({
                "responsive": true,
                "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
                ],
                "order": [[0, 'desc']],
                "language": {
                    "paginate": {
                        "previous": "&lsaquo;",
                        "next": "&rsaquo;"
                    }
                }
            });
        });

        function paying(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                data: { amount: $('#Amount2').val(), order: $('#RefNo').val() },
                type: "post",
                url: "",
               
                success: function(returnData) {
                  
                    if (returnData['success']) {
                        $('#Amount').val(returnData['amount']);
                        $('#UserContact').val(returnData['customer_contact_number']);
                        $('#signature').val(returnData['signature']);
                        $('#ePayment').submit();
                    }
                }
            });
        }

        function pay_now($order,$amt) {       
            $('#RefNo').val($order);
            $('#Amount2').val($amt);
            $('#payment_modal').modal('show');
        }

        function cancel_unpaid_order(id){
            $('#cancel_orderid').html('Cancel Order#: '+id);
            $('#order_number').val(id);            
            $('#cancel_order').modal('show');
        }
    </script>
@endsection
