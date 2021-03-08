@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        #loading-overlay {
            position: absolute;
            width: 100%;
            height:180%;
            left: 0;
            top: 0;
            display: none;
            align-items: center;
            background-color: #000;
            z-index: 999;
            opacity: 0.5;
        }
        .loading-icon{ position:absolute;border-top:2px solid #fff;border-right:2px solid #fff;border-bottom:2px solid #fff;border-left:2px solid #767676;border-radius:25px;width:25px;height:25px;margin:0 auto;position:absolute;left:50%;margin-left:-20px;top:50%;margin-top:-20px;z-index:4;-webkit-animation:spin 1s linear infinite;-moz-animation:spin 1s linear infinite;animation:spin 1s linear infinite;}
        @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
        @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
        @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }

        .datetimepicker{
            font-family: sans-serif, Arial;
        }
        
    </style>
@endsection

@section('content')
    <section>
        <form action="{{route('cart.temp_sales')}}" method="post" id="chk_form">
            @csrf
            <div class="content-wrapper">
                <div class="gap-70"></div>
                <div class="container">
                    <h3 style="font-family:serif;">Checkout</h3>
                    <div class="row jumbotron">
                        <div class="col-md-6" style="font-family:sans-serif, arial;"> 
                            @if(Setting::info()->flatrate_is_allowed == 1)
                                <input type="hidden" id="is_flatrate_enabled" value="1">
                            @endif
                            @php
                                $delivery_fee_amount = 0;  
                                $delivery_fee_text = '0.00';
                            @endphp
                            @if(Setting::info()->min_order_is_allowed == 1 && Setting::info()->min_order > 0 )

                                @php                                     
                                    if($products->sum('itemTotalPrice') >= Setting::info()->min_order){
                                        $delivery_fee_amount = 0;  
                                        $delivery_fee_text = 'Free';  
                                        echo '<input type="hidden" id="is_free" value="1">';
                                    }                                    
                                @endphp
                                <input type="hidden" name="minimum_order" id="minimum_order" value="Setting::info()->min_order">
                            @else
                                <input type="hidden" name="minimum_order" id="minimum_order" value="0">
                            @endif       
                                    
                            @if(!empty(Setting::info()->delivery_note))
                                <div class="alert alert-info" style="margin-bottom:20px;text-align: justify;  text-justify: inter-word;" role="alert">
                                    <i class="fa"></i>{!! Setting::info()->delivery_note !!}
                                </div>
                            @endif
                                
                            @php  $delivery_only = 0;  @endphp
                            <div class="form-group" style="padding-left:20px;"> 
                                <!-- If option 1 and 2 is either selected -->
                                @if(Setting::info()->flatrate_is_allowed == 1 || Setting::info()->min_order_is_allowed == 1 || Setting::info()->delivery_collect_is_allowed == 1) 
                                    <!-- If option 3 and 3 is neither selected then no need to show the delivery-->
                                    @if(Setting::info()->pickup_is_allowed == 1)
                                        <p>How do you want to get your order?<br></p>
                                        <input type="radio" name="shipping_type" id="shipping_type2" value="d2d"> Delivery<br>
                                    @else
                                        <p>How do you want to get your order?<br></p>
                                        <input checked="checked" type="radio" name="shipping_type" id="shipping_type2" value="d2d"> Delivery<br>
                                        @php  $delivery_only = 1;  @endphp
                                    @endif

                                @endif       

                                @if(Setting::info()->pickup_is_allowed == 1)
                                    @if(Setting::info()->flatrate_is_allowed == 1 || Setting::info()->min_order_is_allowed == 1 || Setting::info()->delivery_collect_is_allowed == 1)
                                        <input type="radio" name="shipping_type" id="shipping_type4" value="storepickup"> Store Pickup
                                    @else
                                        <p>How do you want to get your order?<br></p>
                                        <input type="radio" checked="checked" name="shipping_type" id="shipping_type4" value="storepickup"> Store Pickup
                                    @endif
                                @endif
                            </div>                                  
                                
                            <div id="d2d_div" class="card" style="display:@if($delivery_only==1) block @else none @endif;">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-family:serif;">Delivery Information</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table width="100%" style="font-size:12px;">
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td><input type="text" class="orig form-control" value="{{$user->firstname}} {{$user->lastname}}" name="uname1" id="uname1" required=""></td>
                                                </tr>
                                                <tr>
                                                    <td>Contact Number</td>
                                                    <td><input type="text" class="orig form-control" value="{{$user->mobile}}" name="mobile" id="mobile" required=""></td>
                                                </tr>                                            
                                               
                                                <tr>
                                                    <td>Address Line 1 *</td>
                                                    <td>
                                                        <input type="text" name="address_street" id="address_street" value="{{$user->address_street}}" class="form-control" placeholder="Unit No./Building/House No./Street" required>
                                                    </td>                                                
                                                </tr>
                                                <tr>
                                                    <td>Address Line 2 *</td>
                                                    <td>
                                                        <input type="text" name="address_municipality" id="address_municipality" placeholder="Subd/Brgy/Municipality" value="{{$user->address_municipality}}" class="form-control" required>
                                                    </td>                                                
                                                </tr>
                                                <tr>
                                                    <td>City/Province</td>
                                                    <td><select required="required" name="location" id="location" class="form-control">
                                                    <option selected="selected" value="">Select</option>
                                                    @forelse($locations as $loc)
                                                        <option value="{{$loc->name}}|{{$loc->rate}}">{{$loc->name}}</option>
                                                    @empty
                                                    @endforelse
                                                    <option value="Other">Other</option>
                                                </select></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><div class="form-group" style="display:none;" id="delivery_other">
                                                        <span class="text-danger">Note: Our apology, currently we can only cater cities/provinces from the above selections.</span>
                                                        </div> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>   
                                </div>                         
                            </div>

                            <div class="form-group">
                                <label for="shipping_type" class="control-label">Other Instruction:</label>
                                <textarea name="instruction" id="instruction" class="form-control" cols="30" rows="2" style="resize: none;"></textarea>
                                <input type="hidden" name="delivery_address" id="delivery_address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="coupon mb-4">
                                <h3 class="catalog-title">Coupons</h3>
                                <div class="cart-table-2 py-3 mb-2 bg-white">
                                    <div class="cart-table-row px-3 border-bottom-0">
                                        <div style="width:100%;">
                                            <div class="form-group row mb-2">
                                                <div class="col-md-9">
                                                    <input class="form-control" type="text" id="coupon_code" placeholder="Enter Coupon Code">
                                                </div>
                                                <div class="col-md-3 ">
                                                    <button type="button" class="btn btn-success" id="couponManualBtn">Apply</button>
                                                </div>
                                            </div>
                                            <div class="field_wrapper_coupon"></div>
                                            <a href="#" class="small mb-2" onclick="collectibles()"> or click here to  Select from My Coupons</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white" id="couponList">
                                    @php $discountAmount = 0; $discountPercentage = 0; $counter = 0; $totalDeduction = 0; $cproducts  = ''; @endphp

                                    @foreach($coupons as $coupon)
                                        @php $counter++; @endphp
                                        @php
                                            if(isset($coupon->details->amount) && $coupon->details->amount_discount_type == 1){
                                                $discountAmount = $coupon->details->amount;
                                            }

                                            if(isset($coupon->details->discount) && $coupon->details->amount_discount_type == 1){
                                                $discountPercentage = $coupon->details->discount;
                                            }
                                        @endphp
                                        <div class="coupon-item p-2 border rounded mb-1">
                                            <input type="hidden" name="couponid[]" value="{{$coupon->coupon_id}}">
                                            @if(isset($coupon->details->free_product_id))
                                            <input type="hidden" name="freeproductid[]" value="{{$coupon->details->free_product_id}}">
                                            @endif
                                            <div class="row no-gutters">
                                                <div class="col-12">
                                                    <div class="coupon-item-name">
                                                        <h5 class="m-0">{{ $coupon->details->name }}</h5>
                                                    </div>
                                                    <div class="coupon-item-desc small mb-1">
                                                        <span>{{ $coupon->details->description }}</span>
                                                        @if(isset($coupon->product_id))
                                                        <br><span class="text-success">Applied On : {{$coupon->product_details->name}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="coupon-item-btns">
                                                        <button class="btn btn-danger btn-sm couponRemove" id="{{$coupon->coupon_id}}">Remove</button>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="{{ $coupon->details->terms_and_conditions }}">Terms & Conditions</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="coupon_counter" id="coupon_counter" value="{{$counter}}">
                            </div>

                            @php
                                if($discountAmount > 0){
                                    $total = $totalAmount-$discountAmount;
                                    $deductionAmount = $discountAmount;

                                    $total_amount_discount_counter = 1;
                                } elseif($discountPercentage > 0){
                                    $discountAmountPercentage = $discountPercentage/100;
                                    $discount = $totalAmount*$discountAmountPercentage;

                                    $total = $totalAmount-$discount;
                                    $deductionAmount = $discount;

                                    $total_amount_discount_counter = 1;
                                } else {
                                    $total = $totalAmount;
                                    $total_amount_discount_counter = 0;
                                    $deductionAmount = 0;
                                }
                            @endphp
                            
                            <div class="mb-4">
                                <h3 class="catalog-title">Payment Summary</h3>
                                <div class="cart-table-2 px-3 bg-white">
                                    <table class="table">
                                        <tr>
                                            <td>Order:</td>
                                            <td align="right">
                                                <input type="hidden" id="order_amount" name="order_amount" value="{{$totalAmount}}">
                                                <input type="hidden" id="delivery_fee" name="delivery_fee" value="0">
                                                <input type="hidden" id="total_amount" name="total_amount" value="{{$total}}">
                                                &#8369; {{number_format($totalAmount,2)}}</td>
                                        </tr>
                                        
                                        <input type="hidden" id="total_amount_discount_counter" value="{{$total_amount_discount_counter}}">
                                        <input type="hidden" id="total_amount_discount" value="{{$deductionAmount}}">
                                        <tr id="promotion" style="@if($discountAmount > 0 || $discountPercentage > 0) @else display:none @endif;">
                                            <td class="text-danger">Order Discount</td>
                                            <td align="right" class="text-danger" id="total_deduction">
                                                &#8369; {{number_format($deductionAmount,2)}}
                                            </td>
                                        </tr>

                                        <input type="hidden" id="sf_discount_amount" value="0">
                                        <input type="hidden" id="sf_discount_coupon" value="0">
                                        <tr id="delivery_fee_row" style="@if($delivery_fee_text=='0.00') display:none @endif;">
                                            <td>Delivery Fee:</td>
                                            <td align="right">&#8369; <span id="delivery_fee_div">{{$delivery_fee_text}}</span></td>
                                        </tr>

                                        <tr id="sf_discount_row" style="display: none;">
                                            <td class="text-danger">Delivery Discount</td>
                                            <td align="right" class="text-danger">&#8369; <span id="sf_discount_span">0</span></td>
                                        </tr>

                                        <tr style="font-size:20px;font-weight:bold;">
                                            <td>Total:</td>
                                            <td align="right">&#8369; <span id="total_amount_div">{{number_format($total,2)}}</span></td>
                                        </tr>
                                    </table>                    
                                    <div class="form-group text-right">                            
                                         <a class="btn btn-info" style="" href="#" id="sbtbtn" onclick="pay_now();">Pay Now</a>
                                         <div class="spinner-border text-primary" role="status" style="display:none;" id="sbt_loading">
                                              <span class="sr-only">Loading...</span>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gap-70"></div>
            </div>
        </form>
    </section>

    <div id="loading-overlay">
        <div class="loading-icon"></div>
    </div> 

    <input type="hidden" id="totalAmountWithoutCoupon" value="{{number_format($totalWithoutCoupon,2,'.','')}}">
    <input type="hidden" id="totalQty" value="{{$totalQty}}">

    <div id="manual-coupon-details"></div>

    @include('theme.sysu.ecommerce.cart.modal')

@endsection

@section('pagejs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
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

                                $('#manual-coupon-details').append(
                                    '<input type="hidden" id="purchaseproductid'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['purchase_product_id']+'">'+
                                    '<input type="hidden" id="discountpercentage'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['percentage']+'">'+
                                    '<input type="hidden" id="discountamount'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['amount']+'">'+
                                    '<input type="hidden" id="couponname'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['name']+'">'+
                                    '<input type="hidden" id="couponcode'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['coupon_code']+'">'+
                                    '<input type="hidden" id="couponterms'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['terms_and_conditions']+'">'+
                                    '<input type="hidden" id="coupondesc'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['description']+'">'+
                                    '<input type="hidden" id="couponfreeproductid'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['free_product_id']+'">'
                                );

                                if(returnData.coupon_details['amount_discount_type'] == 1){
                                    if(returnData.coupon_details['free_product_id'] != null){
                                        free_product_coupon(returnData.coupon_details['id']);
                                    } else {
                                        use_coupon(returnData.coupon_details['id']);
                                    }
                                } else {
                                    choose_product(returnData.coupon_details['id']);
                                }

                                swal({
                                    title: '',
                                    text: "Coupon has been added.",         
                                });
                            }  
                        }
                    }
                }
            });
        });

        function coupon_counter(){
            var limit = 3;
            var counter = $('#coupon_counter').val();

            if(parseInt(counter) < parseInt(limit)){

                $('#coupon_counter').val(parseInt(counter)+1);
                return true;

            } else {
                swal({
                    title: '',
                    text: "Maximum of three (1) coupons only.",         
                });
                return false;
            }
        }

        function collectibles(){
            var totalAmount = $('#totalAmountWithoutCoupon').val();
            var totalQty = $('#totalQty').val();
            $.ajax({
                type: "GET",
                url: "{{ route('display.collectibles') }}",
                data: {
                    'total_amount' : totalAmount,
                    'total_qty' : totalQty
                },
                success: function( response ) {
                    $('#collectibles').empty();

                    var arr_selected_coupons = [];
                    $("input[name='couponid[]']").each(function() {
                        arr_selected_coupons.push(parseInt($(this).val()));
                    });

                    $.each(response.coupons, function(key, coupon) {
                        if(coupon.amount_discount_type == 1){
                            if(coupon.end_date == null){
                                var validity = '';  
                            } else {
                                if(coupon.end_time == null){
                                    var validity = '<span class="border rounded p-1">Valid Till '+coupon.end_date+'</span>';
                                } else {
                                    var validity = '<span class="border rounded p-1">Valid Till '+coupon.end_date+' '+coupon.end_time+'</span>';
                                }
                            }

                            if(jQuery.inArray(coupon.id, response.availability) !== -1){

                                if(jQuery.inArray(coupon.id, arr_selected_coupons) !== -1){
                                    if(coupon.location == null){
                                        var btn = '<a style="display:none;" href="#" id="couponBtn'+coupon.id+'" onclick="use_coupon('+coupon.id+')"><i class="fa fa-check"></i></a><p id="couponrmv'+coupon.id+'"><a href="#" class="float-right couponRemove" id="'+coupon.id+'" ><i class="fa fa-times"></i></a></p>';
                                    } else {
                                        var btn = '<button type="button" id="couponBtn'+coupon.id+'" class="btn btn-sm btn-primary" onclick="use_sf_coupon('+coupon.id+')" style="display:none;">Use Now</button><span class="text-success" id="couponSpan'+coupon.id+'">Already Use</span>';
                                    }
                                    var status = 'selected';
                                } else {
                                    if(coupon.location == null){
                                        var btn = '<a style="display:none;" href="#" id="couponBtn'+coupon.id+'" onclick="use_coupon('+coupon.id+')"><i class="fa fa-check"></i></a><p id="couponrmv'+coupon.id+'"><a href="#" class="float-right couponRemove" id="'+coupon.id+'" ><i class="fa fa-times"></i></a></p>';
                                    } else {
                                        var btn = '<button type="button" id="couponBtn'+coupon.id+'" class="btn btn-sm btn-primary" onclick="use_sf_coupon('+coupon.id+')" style="display:none;">Use Now</button><span class="text-success" id="couponSpan'+coupon.id+'">Already Use</span>';
                                    }
                                    var status = '';
                                }

                                $('#collectibles').append(
                                    '<div class="coupon-item p-2 border rounded mb-1 '+status+'" id="coupondiv'+coupon.id+'">'+
                                        '<div class="row no-gutters">'+
                                            '<div class="col-12">'+
                                                '<p class="float-right">'+btn+'</p>'+
                                                '<div class="coupon-item-name">'+
                                                    '<input type="hidden" id="purchaseproductid'+coupon.id+'" value="'+coupon.purchase_product_id+'">'+
                                                    '<input type="hidden" id="discountpercentage'+coupon.id+'" value="'+coupon.percentage+'">'+
                                                    '<input type="hidden" id="discountamount'+coupon.id+'" value="'+coupon.amount+'">'+
                                                    '<input type="hidden" id="couponname'+coupon.id+'" value="'+coupon.name+'">'+
                                                    '<input type="hidden" id="couponcode'+coupon.id+'" value="'+coupon.coupon_code+'">'+
                                                    '<input type="hidden" id="couponterms'+coupon.id+'" value="'+coupon.terms_and_conditions+'">'+
                                                    '<input type="hidden" id="coupondesc'+coupon.id+'" value="'+coupon.description+'">'+
                                                    '<input type="hidden" id="couponfreeproductid'+coupon.id+'" value="'+coupon.free_product_id+'">'+
                                                    '<h5 class="m-0">'+coupon.name+'</h5>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-11 small">'+
                                                '<div class="coupon-item-desc">'+
                                                    '<span>'+coupon.description+'</span>'+
                                                '</div>'+
                                                '<div class="coupon-item-valid text-muted mt-2">'+validity+'</div>'+
                                            '</div>'+
                                            '<div class="col-1 small text-right">'+
                                                '<div class="coupon-item-terms"></div>'+
                                                '<button type="button" class="btn btn-default p-0" data-toggle="tooltip" data-placement="top" title="'+coupon.terms_and_conditions+'"><i class="fa fa-info-circle"></i></button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                );
                            } else {
                                $('#collectibles').append(
                                    '<div class="coupon-item p-2 border rounded mb-1 disabled">'+
                                        '<div class="row no-gutters">'+
                                            '<div class="col-12">'+
                                                '<p class="float-right"><a href="#" class="text-muted"><i class="fa fa-ban"></i></a></p>'+
                                                '<div class="coupon-item-name">'+
                                                    '<h5 class="m-0">'+coupon.name+'</h5>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-11 small">'+
                                                '<div class="coupon-item-desc">'+
                                                    '<span>'+coupon.description+'</span>'+
                                                '</div>'+
                                                '<div class="coupon-item-valid text-muted mt-2">'+
                                                    '<div class="coupon-item-valid text-muted mt-2">'+validity+'</div>'+
                                               '</div>'+
                                            '</div>'+
                                            '<div class="col-1 small text-right">'+
                                                '<div class="coupon-item-terms"></div>'+
                                                '<button type="button" class="btn btn-default p-0" data-toggle="tooltip" data-placement="top" title="'+coupon.terms_and_conditions+'"><i class="fa fa-info-circle"></i></button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                );
                            }
                            $("[data-toggle='tooltip']").tooltip();
                        }
                    });
                    $('#exampleModalCenter').modal('show');
                }
            });
        }

        function use_sf_coupon(cid){
            var sfcoupon = parseFloat($('#sf_discount_coupon').val());

            if(sfcoupon == 1){
                swal({
                    title: '',
                    text: "Only one (1) coupon for shipping fee discount.",         
                });
                return false;
            }

            if (!$("input[name='shipping_type']:checked").val()) {
                swal({
                    title: '',
                    text: "Please select a delivery option!",         
                });
            } else {
                var option = $('input[name="shipping_type"]:checked').val();

                if(option == 'storepickup'){
                    swal({
                        title: '',
                        text: "Shipping fee coupon discount is only applicable on Delivery option!",         
                    });
                } else {
                    var selectedLocation = $('#location').val();
                    var loc = selectedLocation.split('|');

                    var couponLocation = $('#sflocation'+cid).val();
                    var cLocation = couponLocation.split('|');

                    var arr_coupon_location = [];
                    $.each(cLocation, function(key, value) {
                        arr_coupon_location.push(value);
                    });

                    if(jQuery.inArray(loc[0], arr_coupon_location) !== -1){

                        var code  = $('#couponcode'+cid).val();
                        var terms = $('#couponterms'+cid).val();

                        
                        $('#couponList').append(
                            '<div class="p-3 border-bottom" id="couponDiv'+cid+'">'+
                                '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                '<p class="float-right sfCouponRemove" id="'+cid+'"><a href="#"><i class="fa fa-times"></i></a></p>'+
                                '<p><span class="h5 float-left"><strong>'+code+'</strong></span></p>'+
                                '<div class="clearfix"></div>'+
                                '<input type="hidden" name="coupon_productid[]" value="0">'+
                                '<p>'+terms+'</p>'+
                            '</div>'
                        );

                        $('#sf_discount_coupon').val(1);
                        var sf_type = $('#sfdiscounttype'+cid).val();
                        var sf_discount = parseFloat($('#sfdiscountamount'+cid).val());

                        if(sf_type == 'full'){
                            dfee = parseFloat($('#delivery_fee').val());

                            $('#sf_discount_amount').val(dfee);

                            $('#sf_discount_row').css('display','table-row');
                            $('#sf_discount_span').html(addCommas(dfee.toFixed(2)));
                        }

                        if(sf_type == 'partial'){
                            $('#sf_discount_amount').val(sf_discount.toFixed(2));

                            $('#sf_discount_row').css('display','table-row');
                            $('#sf_discount_span').html(addCommas(sf_discount.toFixed(2)));
                        }

                        $('#couponBtn'+cid).css('display','none');
                        $('#couponSpan'+cid).css('display','block');

                        compute_total();
                    } else {
                        swal({
                            title: '',
                            text: "Selected delivery location is not in the coupon location.",         
                        });
                    } 
                }
            }
        }

        function use_coupon(cid){
            var totalAmountDiscountCounter = $('#total_amount_discount_counter').val();
            var grandTotal = $('#grandTotal').val();

            var code  = $('#couponcode'+cid).val();
            var terms = $('#couponterms'+cid).val();
            var amount= $('#discountamount'+cid).val();
            var percnt= $('#discountpercentage'+cid).val();

            if(coupon_counter()){
                if(parseInt(totalAmountDiscountCounter) == 1){
                    swal({
                        title: '',
                        text: "Only one (1) coupon with discount amount/percentage per transaction.",         
                    });

                    var counter = $('#coupon_counter').val();
                    $('#coupon_counter').val(parseInt(counter)-1);

                    return false;
                }

                $('#couponList').append(
                    '<div class="p-3 border-bottom" id="couponDiv'+cid+'">'+
                        '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                        '<p class="float-right couponRemove" id="'+cid+'"><a href="#"><i class="fa fa-times"></i></a></p>'+
                        '<p><span class="h5 float-left"><strong>'+code+'</strong></span></p>'+
                        '<div class="clearfix"></div>'+
                        '<input type="hidden" name="coupon_productid[]" value="0">'+
                        '<p>'+terms+'</p>'+
                    '</div>'
                );

                $('#total_amount_discount_counter').val(1); 

                if(amount > 0){ 
                    var amountdiscount = amount;
                }

                if(percnt > 0){
                    var percent  = parseFloat(percnt)/100;
                    var discount = parseFloat(grandTotal)*percent;

                    var amountdiscount = discount;
                }

                $('#couponBtn'+cid).css('display','none');
                $('#couponSpan'+cid).css('display','block');
                $('#total_amount_discount').val(amountdiscount);

                compute_total();
            }
        }

        $(document).on('click', '.couponRemove', function(){  
            var id = $(this).attr("id");  

            $('#promotion').css('display','none');
            $('#total_amount_discount').val(0);

            var totaldiscoutcounter = $('#total_amount_discount_counter').val();
            $('#total_amount_discount_counter').val(parseInt(totaldiscoutcounter)-1);

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            $('#couponBtn'+id).css('display','block');
            $('#couponSpan'+id).css('display','none');
            $('#couponDiv'+id+'').remove();

            compute_total();
        });

        $(document).on('click', '.sfCouponRemove', function(){  
            var id = $(this).attr("id");  

            $('#sf_discount_row').css('display','none');
            
            $('#sf_discount_amount').val(0);
            var totalsfdiscoutcounter = $('#sf_discount_coupon').val();
            $('#sf_discount_coupon').val(parseInt(totalsfdiscoutcounter)-1);

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            $('#couponBtn'+id).css('display','block');
            $('#couponSpan'+id).css('display','none');
            $('#couponDiv'+id+'').remove();

            compute_total();
        });

        

        $("input[name='shipping_type']").click(function(){
            var typ = $(this).val();

            if(typ == 'd2d'){
                $('#d2d_div').show();  
                $('#delivery_fee_row').show();           
            }
            else{
                $('#delivery_fee_div').html('0.00');  
                $('#delivery_fee').val(0);
                $('#location').prop('selectedIndex',0)
                $('#d2d_div').hide();   
                $('#delivery_fee_row').hide();        
            }
            compute_total();   
        });

        function paying_now(){
            $('#paying_div').show();
        }

        function pay_now() {      
            var st = $('input[name="shipping_type"]:checked').val(); 
            if(st == 'd2d'){
                if($('#location').val()==''){
                    swal({
                        title: '',
                        text: 'Please select your city/province.',
                        icon: 'warning'
                    });              
                    return false;
                }
            }

            if($('#address_street').val()==''){
                swal({
                    title: '',
                    text: 'Please enter Address 1.',
                    icon: 'warning'
                });
                return false;
            }

            if($('#address_municipality').val()==''){
                swal({
                    title: '',
                    text: 'Please enter Address 2.',
                    icon: 'warning'
                });
                return false;
            }

            $('#delivery_address').val($('#address_street').val()+', '+$('#address_municipality').val()+', '+$('#location option:selected').text());
            $('#sbtbtn').hide();
            $('#sbt_loading').show();
            $('#chk_form').submit();
        }

        $('#location').change(function(){
            
            if($(this).val() == 'Other'){
                $('#delivery_other').show();
            }
            else if($(this).val() == ''){
                $('#delivery_fee_div').html('0.00');  
                $('#delivery_fee').val(0);
            }
            else{            
                var a = ($(this).val()).split('|');
                if($('#is_free').length){

                }
                else{
                    if($('#is_flatrate_enabled').length){
                        $('#delivery_fee_div').html(addCommas(parseFloat(a[1]).toFixed(2)));  
                        $('#delivery_fee').val(a[1]);   
                        $('#delivery_fee_row').show();    
                    }
                }        
            }
            compute_total();
        });

        function compute_total(){
            var delivery_fee = parseFloat($('#delivery_fee').val());
            var amountDiscount = parseFloat($('#total_amount_discount').val());
            var total_a = parseFloat($('#order_amount').val());

            var sfDiscount = parseFloat($('#sf_discount_amount').val());

            // total amount discount
            if(amountDiscount > 0){
                var total = parseFloat(total_a)-parseFloat(amountDiscount);

                if(sfDiscount > 0){
                    var dfee = delivery_fee-sfDiscount;
                    var gtotal = total + dfee;
                } else {
                    var gtotal = total + delivery_fee;
                }

                $('#promotion').css('display','table-row');
                $('#total_deduction').html('₱ '+addCommas(amountDiscount.toFixed(2)));
            } else {
                var total = total_a;
                var gtotal = total;
                if(sfDiscount > 0){
                    var dfee = delivery_fee-sfDiscount;
                    var gtotal = total + dfee;
                } else {
                    var gtotal = total + delivery_fee;
                }

                $('#promotion').css('display','none');
            }

            $('#total_amount_div').html(addCommas(parseFloat(gtotal).toFixed(2)));
            $('#total_amount').val(gtotal.toFixed(2));
            $('#deposit').val(gtotal);
            $('#dep50').html('(&#8369; '+parseFloat(gtotal)/2+')');
        }


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
        
    </script>
@endsection
