$('#couponManualBtn').click(function(){
            var couponCode = $('#coupon_code').val()

            $.ajax({
                data: {
                    "couponcode": couponCode,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('add-manual-coupon')}}",
                success: function(returnData) {

                    if(returnData['not_exist']){
                        swal({
                            title: '',
                            text: "Coupon not found.",         
                        }); 
                    } else {
                        if(returnData['expired']){
                            swal({
                                title: '',
                                text: "Coupon is already expired.",         
                            }); 
                        } else {
                            if (returnData['success']) {

                                $('#couponList').append(
                                    '<div class="cart-table-2 coupons-list mb-5 border rounded">'+
                                        '<div class="p-3 border-bottom">'+
                                            '<p class="float-right"><a href="#"><i class="fa fa-times"></i></a></p>'+
                                            '<p><span class="h5 float-left"><strong>'+returnData.coupon_details['coupon_code']+'</strong></span></p>'+
                                            '<div class="clearfix"></div>'+
                                            '<p>'+returnData.coupon_details['name']+'</p>'+
                                        '</div>'+
                                    '</div>'
                                );
                                swal({
                                    title: '',
                                    text: "Coupon is pwede.",         
                                });
                            }  
                        }
                    }
                }
            });
        });


        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Your Available Coupons</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-single-tab" data-toggle="tab" href="#nav-single" role="tab" aria-controls="nav-single" aria-selected="true">Single</a>
                        <a class="nav-item nav-link" id="nav-multiple-tab" data-toggle="tab" href="#nav-multiple" role="tab" aria-controls="nav-multiple" aria-selected="false">Multiple <span class="badge badge-success cart-counter">{{ count($customerCoupons) }}</span></a>
                        <a class="nav-item nav-link" id="nav-collectibles-tab" data-toggle="tab" href="#nav-collectibles" role="tab" aria-controls="nav-collectibles" aria-selected="false">Collectibles</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active p-3 border border-top-0 rounded-bottom" id="nav-single" role="tabpanel" aria-labelledby="nav-single-tab">
                        <div class="table-history" style="overflow-x:auto;">
                            <table class="table table-hover small text-left overflow-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="align-middle text-nowrap" width="10%">
                                            <div class="form-check">&nbsp;</div>
                                        </th>
                                        <th scope="col" class="align-middle text-nowrap text-center">Name</th>
                                        <th scope="col" class="align-middle text-nowrap text-center" width="50%">Deal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($customerCoupons)
                                    @foreach($customerCoupons as $coupon)
                                    @if($coupon->details->combination == 0)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="form-check">
                                                <input type="hidden" id="couponcode{{$coupon->coupon_id}}" value="{{$coupon->details->coupon_code}}">
                                                <input type="hidden" id="couponterms{{$coupon->coupon_id}}" value="{{$coupon->details->terms_and_conditions}}">
                                                <input type="radio" name="single-options" class="cb" id="cb{{$coupon->coupon_id}}">
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{$coupon->details->name}}</strong>
                                        </td>
                                        <td class="align-middle" width="30%">
                                            {{$coupon->details->terms_and_conditions    }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @else
                                    <td>
                                        <div class="alert alert-warning" role="alert">
                                            No Record found
                                        </div>
                                    </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="nav-multiple" role="tabpanel" aria-labelledby="nav-multiple-tab">
                        <div class="table-history" style="overflow-x:auto;">
                            <table class="table table-hover small text-left overflow-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="align-middle text-nowrap">Name</th>
                                        <th scope="col" class="align-middle text-nowrap text-center" width="50%">Reward</th>
                                        <th width="15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($customerCoupons)
                                    @foreach($customerCoupons as $coupon)
                                    <tr>
                                        <input type="hidden" id="discountpercentage{{$coupon->coupon_id}}" value="{{$coupon->details->percentage}}">
                                        <input type="hidden" id="discountamount{{$coupon->coupon_id}}" value="{{$coupon->details->amount}}">
                                        <input type="hidden" id="couponcode{{$coupon->coupon_id}}" value="{{$coupon->details->coupon_code}}">
                                        <input type="hidden" id="couponterms{{$coupon->coupon_id}}" value="{{$coupon->details->description}}">
                                        <td>
                                            <strong>{{$coupon->details->name}}</strong>
                                        </td>
                                        <td class="align-middle text-center" width="30%">
                                            {{ $coupon->details->description }}
                                        </td>
                                        <td>
                                            @if($coupon->details->amount_discount_type == 1)
                                            @if (\Route::current()->getName() == 'cart.front.show')
                                            <button type="button" id="couponBtn{{$coupon->coupon_id}}" class="btn btn-sm btn-primary" onclick="use_coupon('{{$coupon->coupon_id}}')">Use Now</button>
                                            @else
                                            <button type="button" id="couponBtn{{$coupon->coupon_id}}" class="btn btn-sm btn-primary" onclick="use_coupon('{{$coupon->coupon_id}}')" style="display: @if(\App\EcommerceModel\CouponCart::coupon_exist($coupon->coupon_id) > 0) none @endif;">Use Now</button>
                                            <span class="text-success" id="couponSpan{{$coupon->coupon_id}}" style="display: @if(\App\EcommerceModel\CouponCart::coupon_exist($coupon->coupon_id) == 0) none @endif;">Already Use</span>
                                            @endif

                                            @endif

                                            @if($coupon->details->amount_discount_type == 2)
                                            <button type="button" id="couponBtn{{$coupon->coupon_id}}" class="btn btn-sm btn-primary" onclick="choose_product('{{$coupon->coupon_id}}')">Use Now</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <td>
                                        <div class="alert alert-warning" role="alert">
                                            No Record found
                                        </div>
                                    </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>  
                    </div>

                    <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="nav-collectibles" role="tabpanel" aria-labelledby="nav-collectibles-tab">
                        <div class="table-history" style="overflow-x:auto;">
                            <table class="table table-hover small text-left overflow-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="align-middle text-nowrap text-center">Name</th>
                                        <th scope="col" class="align-middle text-nowrap text-center" width="50%">Deal</th>
                                        <th scope="col" width="15%"></th>
                                    </tr>
                                </thead>
                                <tbody id="collectibles">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/legande/plugins/vanilla-zoom/vanilla-zoom.css') }}" />
    <style>
        .quantity {
            display: block;
            margin: 0 0 10px;
            position: relative;
        }

        .quantity .product-pcs {
            height: 60px;
            border: solid 1px #dfe3e9;
            display: inline-block;
            font-size: 1.05em;
            font-weight: 500;
            padding: 12px 25px;
            margin-left: -1px;
        }

        .quantity input {
            color: #443017;
            background-color: #ffffff;
            border: solid 1px #ced4da;
            font-family: "Roboto", sans-serif;
            font-size: .85em;
            font-weight: 300;
            max-width: 150px;
            height: 38px;
            float: left;
            display: block;
            padding: 0 30px 0 2px;
            margin: 0;
            text-align: center;
            width: 100%;
            -webkit-transition: all 0.15s ease-in-out;
            transition: all 0.15s ease-in-out;
        }

        .quantity input:focus {
            outline: 0;
            border-color: #981c1e;
        }

        .quantity .quantity-nav {
            float: left;
            position: relative;
            height: 38px;
        }

        .quantity .quantity-nav .quantity-button {
            position: relative;
            cursor: pointer;
            border-left: 1px solid #ced4da;
            width: 25px;
            text-align: center;
            color: #333;
            font-size: 16px;
            font-family: "Trebuchet MS", Helvetica, sans-serif !important;
            line-height: 1;
            -webkit-transform: translateX(-100%);
            transform: translateX(-100%);
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .quantity .quantity-nav .quantity-button:active {
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
            -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .quantity .quantity-nav .quantity-button.quantity-up {
            position: absolute;
            height: 50%;
            top: 0;
            border-bottom: 1px solid #ced4da;
        }

        .quantity .quantity-nav .quantity-button.quantity-down {
            position: absolute;
            bottom: 0px;
            height: 50%;
        }
    </style>
@endsection

@section('content')
    <main>
        <section id="cart-wrapper">
            <div class="container">

                <form action="{{route('cart.front.batch_update')}}" method="post">
                    <div class="row">

                        @csrf
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="total_products" value="{{ $totalProducts }}">
                        <div class="col-lg-9">
                            <div class="cart-title">
                                <h2>My Cart</h2>
                            </div>
                            <ul class="cart-wrap">
                                @forelse($cart as $key => $order)
                                    @php
                                        $product = $order->product;

                                        if (empty($product)) {
                                            continue;
                                        }
                                    @endphp
                                    <input type="hidden" name="record_id[{{$loop->iteration}}]" value="{{$order->product_id}}">
                                    <li class="item">
                                        <div class="remove-item">
                                            @if (auth()->check() && $product->id == 1)
                                            @else
                                                <a href="#" class="removed" style="font-size:.7em;text-transform:uppercase;" onclick="remove_item({{$order->product_id}});">
                                                    Remove <span class="lnr lnr-cross"></span>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-3 col-sm-4">
                                                <div class="img-wrap">
                                                    <a href="{{route('product.front.show',$product->slug)}}"><img src="{{ asset('storage/products/'.$product->photoPrimary) }}" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-md-9">
                                                <div class="info-wrap">
                                                    <div class="cart-description">
                                                        <h3 class="cart-product-title"><a href="{{route('product.front.show',$product->slug)}}">{{$product->name}}</a></h3>
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                                                            <li class="breadcrumb-item active" aria-current="page">@if ($product->category) {{$product->category->name}} @endif</li>
                                                        </ol>
                                                    </div>
                                                    <div class="cart-quantity">
                                                        <label for="quantity">Quantity</label>
                                                        <div class="quantity" @if ($product->id == 1) disabled style="pointer-events:none;" @endif>
                                                            <input type="number" id="quantity{{$loop->iteration}}" name="quantity[{{$loop->iteration}}]" class="qty" min="1" step="1" data-inc="1" value="{{$order->qty}}" @if ($product->id == 1) readonly @endif>
                                                        </div>
                                                    </div>

                                                    <div class="cart-info">
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                @if($product->has_installation == 1)

                                                                    <label class="check check-installation" for="with_installation{{$loop->iteration}}">
                                                                        <input type="checkbox" class="with_installation_cb" id="with_installation{{$loop->iteration}}" name="with_installation[{{$loop->iteration}}]" value="1" @if($order->with_installation) checked @endif>With Installation<span class="checkbox"></span>
                                                                    </label>

                                                                @endif

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="cart-product-price">

                                                                    <p class="text-right brkdwn">Item Price: <span id="total_price{{$loop->iteration}}">{{ $order->str_total_price }}</span></p>
                                                                @if($product->has_installation == 1)
                                                                    <p class="text-right brkdwn">Installation Fee: <span id="total_installation_fee{{$loop->iteration}}">{{$order->str_total_installation_fee}}</span></p>
                                                                @endif
                                                                    <div class="gap-10"></div>
                                                                    <div id="item_total_price{{$loop->iteration}}">
                                                                        {{$order->str_grand_price}}
                                                                    </div>
                                                                </div>

                                                                {{-- Item Price --}}
                                                                <input type="hidden" name="price{{$loop->iteration}}" id="price{{$loop->iteration}}" value="{{$product->price}}">

                                                                {{-- Installation Fee per Item --}}
                                                                <input type="hidden" id="installation_fee{{$loop->iteration}}" name="installation_fee{{$loop->iteration}}" value="{{$product->installation_fee}}">

                                                                {{-- Sub Total Price --}}
                                                                <input type="hidden" id="sum_sub_price{{$loop->iteration}}" name="sum_sub_price{{$loop->iteration}}" value="{{$order->itemTotalPrice}}">

                                                                {{-- Grand Total Price --}}
                                                                <input type="hidden" id="sum_total_price{{$loop->iteration}}" name="sum_total_price{{$loop->iteration}}" value="{{$order->grand_price}}">

                                                                {{-- Total Installation Fee --}}
                                                                <input type="hidden" id="sum_installation_fee{{$loop->iteration}}" name="sum_installation_fee{{$loop->iteration}}" value="{{$order->item_total_installation_fee}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                @endforelse

                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <!-- Hidden fields -->
                            <input type="hidden" name="summary_subtotal" id="summary_subtotal">
                            <input type="hidden" name="summary_installation_fee" id="summary_installation_fee">
                            <input type="hidden" name="summary_grandtotal" id="summary_grandtotal">

                            <div class="cart-title">
                                <h2>Summary</h2>
                            </div>
                            <div class="summary-wrap">

                                <div class="grand-total">
                                    <div class="table">
                                        <div class="table-row">
                                            <div class="table-cell">
                                                Subtotal
                                            </div>
                                            <div class="table-cell" id="grandSubTotal">
                                                Php 0.00
                                            </div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-cell">
                                                Total Installation Fee
                                            </div>
                                            <div class="table-cell" id="grandInstallationTotal">
                                                Php 0.00
                                            </div>
                                        </div>
                                        <div class="gap-40"></div>
                                        <div class="table-row">
                                            <div class="table-cell total-bold">
                                                <strong>Grand Total</strong>
                                            </div>
                                            <div class="table-cell total-bold" id="grandtotal">
                                                <strong>Php 0.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shipping-message">Shipping fee/s will apply <span class="white-spc">upon checkout</span></div>
                                <div class="cart-btn">
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-lg secondary-btn" name="submit" value="update">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-lg primary-btn" name="submit" value="checkout">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div style="display:none;">
                <form id="remove_form" method="post" action="{{route('cart.remove_product')}}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="product_remove_id" id="product_remove_id" value="">
                    <button type="submit" href="#" class="removed" style="font-size:.7em;text-transform:uppercase;">
                        Remove <span class="lnr lnr-cross"></span>
                    </button>
                </form>
            </div>
        </section>
    </main>
@endsection

@section('jsscript')
    <script src="{{ asset('theme/legande/plugins/sweetalert/sweet-alert.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            @if(Session::has('success'))
                swal({
                    toast: true,
                    position: 'center',
                    title: "{{ session('success', '') }}",
                    type: "success",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            @endif

            @if(Session::has('failed'))
                swal({
                    toast: true,
                    position: 'center',
                    title: "{{ session('failed', '') }}",
                    type: "error",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            @endif
        });
        $('.qty').change(function() {
            if ($(this).val().trim() == '') {
                $(this).val(1);
            }

            let id = $(this).attr('id').replace('quantity','');

            update_installation_fee_per_item(id);

            update_sub_total_price_per_item(id);

            update_total_price_per_item(id);

            compute_grand_total();
        });

        function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        function compute_grand_total(){

            let summary_sub_price = 0;
            let summary_installation_price = 0;
            let grand_price = 0;

            for(x=1;x<={{ $totalProducts }};x++){
                grand_price+=parseFloat($('#sum_total_price'+x).val());
                summary_sub_price+=parseFloat($('#sum_sub_price'+x).val());
                summary_installation_price+=parseFloat($('#sum_installation_fee'+x).val());
            }


            $('#grandtotal').html('Php '+addCommas(grand_price.toFixed(2)));
            $('#grandSubTotal').html('Php '+addCommas(summary_sub_price.toFixed(2)));
            $('#grandInstallationTotal').html('Php '+addCommas(summary_installation_price.toFixed(2)));

            $('#summary_subtotal').val(summary_sub_price);
            $('#summary_installation_fee').val(summary_installation_price);
            $('#summary_grandtotal').val(grand_price);
        }


        $(document).ready(function(){
            compute_grand_total();
        });


        function remove_item(i){
            var r = confirm("Are you sure you want to remove this item?");
            if (r == true) {

                $('#product_remove_id').val(i);
                $('#remove_form').submit();

            } else {
                return false;
            }
        }

        $('.with_installation_cb').change(function(){

            let id = $(this).attr('id').replace('with_installation','');

            update_installation_fee_per_item(id);

            update_total_price_per_item(id);

            compute_grand_total();
        });

        function update_installation_fee_per_item(id){

            if($('#with_installation'+id).is(':checked')) {

                var ins_fee = parseFloat($('#quantity'+id).val()) * parseFloat($('#installation_fee'+id).val());
                $('#total_installation_fee'+id).html('Php '+ addCommas(ins_fee.toFixed(2)));
                $('#sum_installation_fee'+id).val(ins_fee);
            }
            else{
                $('#total_installation_fee'+id).html('Php 0.00');
                $('#sum_installation_fee'+id).val(0);
            }

        }

        function update_sub_total_price_per_item(id){

            var pr = parseFloat($('#quantity'+id).val()) * parseFloat($('#price'+id).val());

            $('#total_price'+id).html('Php '+ addCommas(pr.toFixed(2)));
            $('#sum_sub_price'+id).val(pr);

        }

        function update_total_price_per_item(id){

            var installation = $('#sum_installation_fee'+id).val();
            var pr = $('#sum_sub_price'+id).val();
            var totalprice = parseFloat(installation) + parseFloat(pr);

            $('#sum_total_price'+id).val(totalprice);
            $('#item_total_price'+id).html('Php '+ addCommas(totalprice.toFixed(2)));

        }


    </script>
@endsection
