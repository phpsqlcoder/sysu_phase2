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
                                                <div class="col-md-12">
                                                    <input class="form-control" type="text" id="coupon_code" placeholder="Enter Coupon Code">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-2">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-block btn-success" id="couponManualBtn">Apply Coupon</button>
                                                </div>
                                            </div>
                                            <div class="field_wrapper_coupon"></div>
                                            <a href="#" class="small mb-2" onclick="collectibles()"> or click here to  Select from My Coupons</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white" id="couponList">
                                    @php $counter = 0; $soloCouponCounter = 0; @endphp

                                    @foreach($coupons as $coupon)
                                        @php 
                                            $counter++; 

                                            if($coupon->details->combination == 0){
                                                $soloCouponCounter++;
                                            }
                                        @endphp
                                        <div class="coupon-item p-2 border rounded mb-1" id="couponDiv{{$coupon->coupon_id}}">
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
                                                        <a href="{{ route('checkout.remove-coupon',$coupon->id) }}" class="btn btn-danger btn-sm text-white">Remove</a>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="{{ $coupon->details->terms_and_conditions }}">Terms & Conditions</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="coupon_counter" id="coupon_counter" value="{{$counter}}">
                            </div>
                            
                            <div class="mb-4">
                                <h3 class="catalog-title">Payment Summary</h3>
                                <div class="cart-table-2 px-3 bg-white">
                                    <table class="table">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td align="right">
                                                <input type="hidden" id="order_amount" name="order_amount" value="{{$totalAmount}}">
                                                <input type="hidden" id="total_amount" name="total_amount" value="{{$grandTotal}}">
                                                &#8369; {{number_format($subtotal,2)}}
                                            </td>
                                        </tr>

                                        <input type="hidden" id="promo_total_discount" name="promo_total_discount" value="{{$total_promo_discount}}">
                                        <tr class="text-danger" style="display: @if($total_promo_discount > 0) table-row @else none; @endif;">
                                            <td>Promo Discount</td>
                                            <td align="right">
                                                &#8369; {{number_format($total_promo_discount,2)}}
                                            </td>
                                        </tr>

                                        <input type="hidden" id="coupon_total_discount" name="coupon_total_discount" value="{{$coupon_total_discount}}">
                                        <tr class="text-danger" style="display: @if($coupon_total_discount > 0) table-row @else none; @endif;">
                                            <td>Coupon Discount</td>
                                            <td align="right">
                                                &#8369; <span id="total_coupon_deduction">{{number_format($coupon_total_discount,2)}}</span>
                                            </td>
                                        </tr>

                                        <input type="hidden" id="total_amount_discount_counter" value="{{$total_amount_discount_counter}}">

                                        <input type="hidden" id="sf_discount_amount" value="0">
                                        <input type="hidden" id="sf_discount_coupon" value="0">
                                        <input type="hidden" id="delivery_fee" name="delivery_fee" value="0">
                                        <tr id="delivery_fee_row" style="@if($delivery_fee_text=='0.00') display:none @endif;">
                                            <td>Delivery Fee:</td>
                                            <td align="right">&#8369; <span id="delivery_fee_div">{{$delivery_fee_text}}</span></td>
                                        </tr>

                                        <tr id="sf_discount_row" style="display: none;">
                                            <td class="text-danger">Delivery Discount</td>
                                            <td align="right" class="text-danger">&#8369; <span id="sf_discount_span">0</span></td>
                                        </tr>

                                        <tr style="font-size:20px;font-weight:bold;">
                                            <td>TOTAL:</td>
                                            <td align="right">&#8369; <span id="total_amount_div">{{number_format($grandTotal,2)}}</span></td>
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

    <input type="hidden" id="totalAmountWithoutCoupon" value="{{number_format($totalAmount,2,'.','')}}">
    <input type="hidden" id="totalQty" value="{{$totalQty}}">

    <div id="manual-coupon-details"></div>
    <input type="hidden" id="coupon_limit" value="{{ Setting::info()->coupon_limit }}">
    <input type="hidden" id="solo_coupon_counter" value="{{$soloCouponCounter}}">

    @include('theme.sysu.ecommerce.cart.modal')

@endsection

@section('pagejs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $('#couponManualBtn').click(function(){
            var couponCode = $('#coupon_code').val();
            var grandtotal = parseFloat($('#total_amount').val());

            $.ajax({
                data: {
                    "couponcode": couponCode,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('add-manual-coupon')}}",
                success: function(returnData) {
                    if(returnData['not_allowed']){
                        swal({
                            title: '',
                            text: "Sorry, you are not authorized to use this coupon.",         
                        });
                        return false;
                    }
                    
                    if(returnData['exist']){
                        swal({
                            title: '',
                            text: "Coupon already used.",         
                        }); 
                        return false;
                    }

                    if(returnData['not_exist']){
                        swal({
                            title: '',
                            text: "Coupon not found.",         
                        }); 
                        return false;
                    }

                    if(returnData['expired']){
                        swal({
                            title: '',
                            text: "Coupon is already expired.",         
                        }); 
                        return false;
                    }

                    if (returnData['success']) {

                        $('#manual-coupon-details').append(
                            '<input type="hidden" id="sflocation'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['location']+'">'+
                            '<input type="hidden" id="sfdiscounttype'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['location_discount_type']+'">'+
                            '<input type="hidden" id="sfdiscountamount'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['location_discount_amount']+'">'+
                            '<input type="hidden" id="purchaseproductid'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['purchase_product_id']+'">'+
                            '<input type="hidden" id="discountpercentage'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['percentage']+'">'+
                            '<input type="hidden" id="discountamount'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['amount']+'">'+
                            '<input type="hidden" id="couponname'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['name']+'">'+
                            '<input type="hidden" id="couponcode'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['coupon_code']+'">'+
                            '<input type="hidden" id="couponterms'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['terms_and_conditions']+'">'+
                            '<input type="hidden" id="coupondesc'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['description']+'">'+
                            '<input type="hidden" id="couponfreeproductid'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['free_product_id']+'">'
                        );

                        if(returnData.coupon_details['location'] == null){
                            if(returnData.coupon_details['amount_discount_type'] == 1){
                                if(returnData.coupon_details['free_product_id'] != null){
                                    free_product_coupon(returnData.coupon_details['id']);
                                } else {
                                    if(returnData.coupon_details['amount'] > 0){ 
                                        var amountdiscount = parseFloat(returnData.coupon_details['amount']);
                                    }

                                    if(returnData.coupon_details['percentage'] > 0){
                                        var percent  = parseFloat(returnData.coupon_details['percentage'])/100;
                                        var discount = parseFloat(grandtotal)*percent;

                                        var amountdiscount = parseFloat(discount);
                                    }

                                    var total = grandtotal-amountdiscount;
                                    if(total.toFixed(2) < 1){
                                        swal({
                                            title: '',
                                            text: "The total amount is less than the coupon discount.",         
                                        });

                                        return false;
                                    }
                                    use_coupon_total_amount(returnData.coupon_details['id']);
                                }
                            }
                        } else {
                            if(returnData.coupon_details['amount'] > 0){ 
                                var amountdiscount = parseFloat(returnData.coupon_details['amount']);
                            }

                            if(returnData.coupon_details['percentage'] > 0){
                                var percent  = parseFloat(returnData.coupon_details['percentage'])/100;
                                var discount = parseFloat(grandtotal)*percent;

                                var amountdiscount = parseFloat(discount);
                            }

                            var total = grandtotal-amountdiscount;
                            if(total.toFixed(2) < 1){
                                swal({
                                    title: '',
                                    text: "The total amount is less than the coupon discount.",         
                                });

                                return false;
                            }
                            
                            use_sf_coupon(returnData.coupon_details['id']);
                        }
                    } 
                }
            });
        });

        function coupon_counter(cid){
            var limit = $('#coupon_limit').val();
            var counter = $('#coupon_counter').val();
            var solo_coupon_counter = $('#solo_coupon_counter').val();

            var combination = $('#couponcombination'+cid).val();
            if(parseInt(counter) < parseInt(limit)){

                if(combination == 0){
                    if(counter > 0){
                        swal({
                            title: '',
                            text: "Coupon cannot be used together with other coupons.",         
                        });
                        return false;
                    } else {
                        $('#solo_coupon_counter').val(1);
                        $('#coupon_counter').val(parseInt(counter)+1);
                        return true;
                    }
                } else {
                    if(solo_coupon_counter > 0){
                        swal({
                            title: '',
                            text: "Unable to use this coupon. A coupon that cannot be used together with other coupon is already been selected.",         
                        });
                        return false;
                    } else {
                        $('#coupon_counter').val(parseInt(counter)+1);
                        return true;
                    }
                }
            } else {
                swal({
                    title: '',
                    text: "Maximum of "+limit+" coupon(s) only.",         
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
                    'total_qty' : totalQty,
                    'page_name' : 'checkout',
                },
                success: function( response ) {
                    $('#collectibles').empty();

                    var arr_selected_coupons = [];
                    $("input[name='couponid[]']").each(function() {
                        arr_selected_coupons.push(parseInt($(this).val()));
                    });

                    $.each(response.coupons, function(key, coupon) {
                        if(coupon.end_date == null){
                            var validity = '';  
                        } else {
                            if(coupon.end_time == null){
                                var validity = ' Valid Till '+coupon.end_date;
                            } else {
                                var validity = ' Valid Till '+coupon.end_date+' '+coupon.end_time;
                            }
                        }

                        if(jQuery.inArray(coupon.id, response.availability) !== -1){

                            if(jQuery.inArray(coupon.id, arr_selected_coupons) !== -1){
                                var usebtn = '<button class="btn btn-success btn-sm" disabled>Applied</button>';
                            } else {
                                if(coupon.location == null){
                                    var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_total_amount('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                } else {
                                    var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_sf_coupon('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                }
                            }

                            $('#collectibles').append(
                                '<div class="coupon-item p-2 border rounded mb-1" id="coupondiv'+coupon.id+'">'+
                                    '<div class="row no-gutters">'+
                                        '<div class="col-12">'+
                                            '<input type="hidden" id="couponcombination'+coupon.id+'" value="'+coupon.combination+'">'+
                                            '<input type="hidden" id="sflocation'+coupon.id+'" value="'+coupon.location+'">'+
                                            '<input type="hidden" id="sfdiscountamount'+coupon.id+'" value="'+coupon.location_discount_amount+'">'+
                                            '<input type="hidden" id="sfdiscounttype'+coupon.id+'" value="'+coupon.location_discount_type+'">'+
                                            '<input type="hidden" id="discountpercentage'+coupon.id+'" value="'+coupon.percentage+'">'+
                                            '<input type="hidden" id="discountamount'+coupon.id+'" value="'+coupon.amount+'">'+
                                            '<input type="hidden" id="couponname'+coupon.id+'" value="'+coupon.name+'">'+
                                            '<input type="hidden" id="couponcode'+coupon.id+'" value="'+coupon.coupon_code+'">'+
                                            '<input type="hidden" id="couponterms'+coupon.id+'" value="'+coupon.terms_and_conditions+'">'+
                                            '<input type="hidden" id="coupondesc'+coupon.id+'" value="'+coupon.description+'">'+
                                            '<div class="coupon-item-name">'+
                                                '<h5 class="m-0">'+coupon.name+' <br><span>'+validity+'</span></h5>'+
                                            '</div>'+
                                            '<div class="coupon-item-desc small mb-1">'+
                                                '<span>'+coupon.description+'</span>'+
                                            '</div>'+
                                            '<div class="coupon-item-btns">'+
                                                usebtn+'&nbsp;'+
                                                '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+coupon.terms_and_conditions+'">Terms & Conditions</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'
                            );
                        } else {
                            $('#collectibles').append(
                                '<div class="coupon-item p-2 border rounded mb-1 deactivate">'+
                                    '<div class="row no-gutters">'+
                                        '<div class="col-12">'+
                                            '<div class="coupon-item-name">'+
                                                '<h5 class="m-0">'+coupon.name+' <span>'+validity+'</span></h5>'+
                                            '</div>'+
                                            '<div class="coupon-item-desc small mb-1">'+
                                                '<span>'+coupon.description+'</span>'+
                                            '</div>'+
                                            '<div class="coupon-item-btns">'+
                                                '<button class="btn btn-success btn-sm disabled">Use Coupon</button>&nbsp;'+
                                                '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+coupon.terms_and_conditions+'">Terms & Conditions</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'
                            );
                        }

                        $('[data-toggle="popover"]').popover(); 
                        
                    });
                    $('#exampleModalCenter').modal('show');
                }
            });
        }
        
        // shipping fee coupon rewards
            function use_sf_coupon(cid){
                // check total use shipping fee coupons
                var sfcoupon = parseFloat($('#sf_discount_coupon').val());

                if(sfcoupon == 1){
                    swal({
                        title: '',
                        text: "Only one (1) coupon for shipping fee discount.",         
                    });
                    return false;
                }

                // check if has selected delivery location
                if (!$("input[name='shipping_type']:checked").val()) {
                    swal({
                        title: '',
                        text: "Please select a delivery option!",         
                    });
                    return false;
                }

                // check if selected coupon applicable on selected delivery location
                var option = $('input[name="shipping_type"]:checked').val();
                if(option == 'storepickup'){
                    swal({
                        title: '',
                        text: "Shipping fee coupon discount is only applicable on Delivery option!",         
                    });
                    return false;
                }
                
                if(coupon_counter(cid)){
                    var selectedLocation = $('#location').val();
                    var loc = selectedLocation.split('|');

                    var couponLocation = $('#sflocation'+cid).val();
                    var cLocation = couponLocation.split('|');

                    var arr_coupon_location = [];
                    $.each(cLocation, function(key, value) {
                        arr_coupon_location.push(value);
                    });

                    if(jQuery.inArray(loc[0], arr_coupon_location) !== -1 || jQuery.inArray('all', arr_coupon_location) !== -1){

                        var name  = $('#couponname'+cid).val();
                        var terms = $('#couponterms'+cid).val();
                        var desc = $('#coupondesc'+cid).val();
                        var combination = $('#couponcombination'+cid).val();
                        
                        $('#couponList').append(
                            '<div id="couponDiv'+cid+'">'+
                                '<div class="coupon-item p-2 border rounded mb-1">'+
                                    '<div class="row no-gutters">'+
                                        '<div class="col-12">'+
                                            '<div class="coupon-item-name">'+
                                                '<h5 class="m-0">'+name+' <span></span></h5>'+
                                            '</div>'+
                                            '<div class="coupon-item-desc small mb-1">'+
                                                '<span>'+desc+'</span>'+
                                            '</div>'+
                                            '<div class="coupon-item-btns">'+
                                                '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
                                                '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                                '<input type="hidden" name="coupon_productid[]" value="0">'+
                                                '<button type="button" class="btn btn-danger btn-sm sfCouponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                                '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+terms+'">Terms & Conditions</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
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

                        $('#couponBtn'+cid).prop('disabled',true);
                        $('#btnCpnTxt'+cid).html('Applied');

                        compute_total();
                    } else {
                        swal({
                            title: '',
                            text: "Selected delivery location is not in the coupon location.",         
                        });
                    } 
                }
            }

            $(document).on('click', '.sfCouponRemove', function(){  
                var id = $(this).attr("id");  

                $('#sf_discount_row').css('display','none');
                
                $('#sf_discount_amount').val(0);
                var totalsfdiscoutcounter = $('#sf_discount_coupon').val();
                $('#sf_discount_coupon').val(parseInt(totalsfdiscoutcounter)-1);

                var counter = $('#coupon_counter').val();
                $('#coupon_counter').val(parseInt(counter)-1);

                var combination = $('#coupon_combination'+id).val();
                if(combination == 0){
                    $('#solo_coupon_counter').val(0);
                }

                $('#couponDiv'+id+'').remove();

                compute_total();
            });
        //

        //total amount coupon rewards
            function use_coupon_total_amount(cid){
                var totalAmountDiscountCounter = $('#total_amount_discount_counter').val();
                var name  = $('#couponname'+cid).val();
                var desc = $('#coupondesc'+cid).val();
                var terms = $('#couponterms'+cid).val();
                var combination = $('#couponcombination'+cid).val();

                if(coupon_counter(cid)){
                    if(parseInt(totalAmountDiscountCounter) == 1){
                        swal({
                            title: '',
                            text: "Only one (1) coupon with discount amount/percentage per transaction.",         
                        });

                        var counter = $('#coupon_counter').val();
                        $('#coupon_counter').val(parseInt(counter)-1);

                        return false;
                    }

                    $('#total_amount_discount_counter').val(1);
                    $('#couponBtn'+cid).prop('disabled',true);
                    $('#btnCpnTxt'+cid).html('Applied');

                    $('#couponList').append(
                        '<div id="couponDiv'+cid+'">'+
                            '<div class="coupon-item p-2 border rounded mb-1">'+
                                '<div class="row no-gutters">'+
                                    '<div class="col-12">'+
                                        '<div class="coupon-item-name">'+
                                            '<h5 class="m-0">'+name+' <span></span></h5>'+
                                        '</div>'+
                                        '<div class="coupon-item-desc small mb-1">'+
                                            '<span>'+desc+'</span>'+
                                        '</div>'+
                                        '<div class="coupon-item-btns">'+
                                            '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
                                            '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                            '<input type="hidden" name="coupon_productid[]" value="0">'+
                                            '<button type="button" class="btn btn-danger btn-sm couponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                            '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+terms+'">Terms & Conditions</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    $('[data-toggle="popover"]').popover();

                    var grandTotal = $('#total_amount').val();
                    var amount = $('#discountamount'+cid).val();
                    var percnt= $('#discountpercentage'+cid).val();
                    if(amount > 0){ 
                        var amountdiscount = parseFloat(amount);
                    }

                    if(percnt > 0){
                        var percent  = parseFloat(percnt)/100;
                        var discount = parseFloat(grandTotal)*percent;

                        var amountdiscount = parseFloat(discount);
                    }

                    var coupon_discount = parseFloat($('#coupon_total_discount').val());

                    var total_coupon_deduction = coupon_discount+amountdiscount;
                    $('#coupon_total_discount').val(total_coupon_deduction.toFixed(2));
                    $('#total_coupon_deduction').html(addCommas(total_coupon_deduction.toFixed(2))); 

                    //$('#total_amount_discount').val(amountdiscount.toFixed(2));
                    compute_total();
                }
            }

            $(document).on('click', '.couponRemove', function(){  
                var id = $(this).attr("id");  

                $('#promotion').css('display','none');
                //$('#total_amount_discount').val(0);

                var totaldiscoutcounter = $('#total_amount_discount_counter').val();
                //$('#total_amount_discount_counter').val(parseInt(totaldiscoutcounter)-1);
                $('#total_amount_discount_counter').val(0);

                var counter = $('#coupon_counter').val();
                $('#coupon_counter').val(parseInt(counter)-1);

                var combination = $('#coupon_combination'+id).val();
                if(combination == 0){
                    $('#solo_coupon_counter').val(0);
                }

                $('#couponDiv'+id+'').remove();

                compute_total();
            });
        //

        // select delivery option
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

                compute_total();       
            }
        });

        function paying_now(){
            $('#paying_div').show();
        }

        function pay_now() {   
            if (!$("input[name='shipping_type']:checked").val()) {
                swal({
                    title: '',
                    text: "Please select a delivery method!",         
                });

               return false;
            }

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

            var sf_counter = $('#sf_discount_coupon').val();

            if(sf_counter > 0){

                var id = $('.sfCouponRemove').attr("id");

                $('#sf_discount_row').css('display','none');
                
                $('#sf_discount_amount').val(0);
                var totalsfdiscoutcounter = $('#sf_discount_coupon').val();
                $('#sf_discount_coupon').val(parseInt(totalsfdiscoutcounter)-1);

                var counter = $('#coupon_counter').val();
                $('#coupon_counter').val(parseInt(counter)-1);

                var combination = $('#coupon_combination'+id).val();
                if(combination == 0){
                    $('#solo_coupon_counter').val(0);
                }

                $('#couponDiv'+id+'').remove();

            }

            compute_total();
        });

        function compute_total(){
            var delivery_fee = parseFloat($('#delivery_fee').val());
            var delivery_discount = parseFloat($('#sf_discount_amount').val());

            var orderAmount = parseFloat($('#order_amount').val());
            var couponDiscount = parseFloat($('#coupon_total_discount').val());

            var orderTotal  = orderAmount-couponDiscount;
            var deliveryFee = delivery_fee-delivery_discount;

            var grandTotal = parseFloat(orderTotal)+parseFloat(deliveryFee);

            $('#total_amount_div').html(addCommas(parseFloat(grandTotal).toFixed(2)));
            $('#total_amount').val(grandTotal.toFixed(2));
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
