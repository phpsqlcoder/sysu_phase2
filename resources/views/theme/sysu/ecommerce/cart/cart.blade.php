@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
    

    <main>
        <section class="py-5">
            <div class="container">
                <form method="POST" action="{{route('cart.front.batch_update')}}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 pb-5">
                            <h3 class="catalog-title">My Carts</h3>
                            @php
                                $total = 0;
                                $total_product_count=0;
                                $cproducts  = '';
                            @endphp
                            @forelse($cart as $key => $order)
                                @php
                                    $total_product_count++;
                                    $product = $order->product;
                                    $total += $order->product->discountedprice*$order->qty;
                                    $max = $product->Maxpurchase;
                                    if (empty($product)) {
                                        continue;
                                    }

                                    $cproducts .= $order->product_id.'|';
                                @endphp
                                
                                <input type="hidden" id="record_id{{$loop->iteration}}" name="record_id[{{$loop->iteration}}]" value="{{$order->id}}">
                                <input type="hidden" id="pp{{$loop->iteration}}" value="{{$order->product_id}}">
                                <div class="cart-table mb-3">
                                    <div class="cart-table-item">
                                        <div class="cart-table-remove">
                                            <a href="#" onclick="remove_item('{{$order->id}}');" class="btn btn-primary btn-sm btn-warning">Remove Item</a>
                                        </div>

                                        <div class="row no-gutters">
                                            <div class="col-lg-4 col-md-5 col-3 p-3">
                                                <a href="{{route('product.front.show',$product->slug)}}" class="prod-avatar"><img src="{{ asset('storage/products/'.$product->photoPrimary) }}" alt=""></a>
                                            </div>
                                            <div class="col-lg-6 col-md-7 col-9 p-3">
                                                <div class="cart-table-content">
                                                    <a href="{{route('product.front.show',$product->slug)}}" class="prod-name">{{$product->name}}</a>
                                                    <nav aria-label="breadcrumb">
                                                        <ol class="breadcrumb small m-0">
                                                            <li class="breadcrumb-item"><a href="#">Products</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page">@if ($product->category) {{$product->category->name}} @endif</li>
                                                        </ol>
                                                    </nav>                                                    
                                                    <div class="prod-qty">
                                                        <small>Quantity</small>
                                                        <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-default btn-number minus-btn" 
                                                                @if($order->qty <= 1) disabled="disabled" @endif
                                                                data-type="minus" data-field="quantity[{{$loop->iteration}}]">
                                                                    <span class="fa fa-minus"></span>
                                                                </button>
                                                            </span>                                                           
                                                            <input type="number" id="quantity{{$loop->iteration}}" name="quantity[{{$loop->iteration}}]" class="form-control input-number quantity-fld qty" readonly="readonly" min="1" step="1" max="1000000" value="{{$order->qty}}">
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-default btn-number plus-btn" data-type="plus" data-field="quantity[{{$loop->iteration}}]">
                                                                    <span class="fa fa-plus"></span>
                                                                </button>
                                                            </span>
                                                            <input type="hidden" id="maxorder{{$loop->iteration}}" value="{{ $max }}">
                                                        </div>
                                                    </div>
                                                    <small>Total</small>
                                                    <div class="prod-total" id="product_total_price{{$loop->iteration}}" style="font-weight:bold;">₱ {{number_format($order->product->discountedprice*$order->qty,2)}}</div>
                                                    <div class="prod-total" id="product_new_price{{$loop->iteration}}" style="font-weight:bold;"></div>
                                                    
                                                    <input type="hidden" class="loop-iteration" id="cart_product_{{$loop->iteration}}" value="{{$loop->iteration}}">
                                                    <input type="hidden" id="cart_product_reward{{$loop->iteration}}" value="0">
                                                    <input type="hidden" id="cart_product_discount{{$loop->iteration}}" value="0">

                                                    <input type="hidden" id="product_name_{{$loop->iteration}}" value="{{$product->name}}">
                                                    <input type="hidden" name="price{{$loop->iteration}}" id="price{{$loop->iteration}}" value="{{number_format($product->discountedprice,2,'.','')}}">
                                                    <input type="hidden" id="sum_sub_price{{$loop->iteration}}" name="sum_sub_price{{$loop->iteration}}" value="{{number_format($order->product->discountedprice*$order->qty,2,'.','')}}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-primary" role="alert">
                                    Your shopping cart is <strong>empty</strong>.
                                </div>
                            @endforelse
                            <input type="hidden" id="cproducts" value="{{$cproducts}}">
                        </div>

                        <div class="col-lg-4">
                            <div class="coupon mb-2">
                                <h3 class="catalog-title">Coupon</h3>
                            
                                <div class="cart-table-2 pt-3">
                                    <div class="cart-table-row px-3">
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
                                    <div class="cart-table-row">
                                        <div class="cart-table-1-col">
                                            <p class="small font-italic pb-3">Coupon(s) will apply upon checkout</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-table-2 coupons-list mb-5 rounded" id="couponList">
                                <input type="hidden" id="coupon_counter" name="coupon_counter" value="0">
                            </div>

                            
                            <div class="mb-5">
                                <h3 class="catalog-title">Summary</h3>

                                <div class="cart-table-2">
                                    <div class="cart-table-row">
                                        <div class="cart-table-2-col">
                                            <div class="cart-table-2-title">Subtotal</div>                                  
                                        </div>
                                        <div class="cart-table-2-col">
                                            <div class="cart-table-2-title text-right" id="total_sub">₱ {{number_format($total,2)}}</div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="total_amount_discount_counter" value="0">
                                    <div class="cart-table-row promotionDiv" style="display: none;">
                                        <div class="cart-table-row">
                                            <div class="cart-table-2-col">
                                                <div class="cart-table-2-title text-danger">Order Discount</div>                                  
                                            </div>
                                            <div class="cart-table-2-col">
                                                <div class="cart-table-2-title text-right text-danger" id="total_deduction"></div>                                   
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="total_amount_discount" value="0">
                                    <div class="cart-table-row">
                                        <div class="cart-table-2-col">
                                            <div class="cart-table-2-title"><strong>Grand Total</strong></div>
                                        </div>
                                        <div class="cart-table-2-col">
                                            <input type="hidden" id="grandTotal" value="{{number_format($total,2,'.','')}}">
                                            <div class="cart-table-2-title text-right" id="total_grand" style="font-weight:bold">₱ {{number_format($total,2)}}</div>
                                        </div>
                                    </div>

                                    <div class="cart-table-row">
                                        <div class="cart-table-1-col">
                                            <p class="small font-italic pb-3">Shipping fees will apply upon checkout</p>
                                            <input type="hidden" name="total_products" value="{{$total_product_count}}">
                                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Proceed to Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>        
    </main>
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

    @include('admin.coupon.modal')
@endsection

@section('pagejs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

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
            var qty = $(this).val();
            if ($(this).val().trim() == '') {
                $(this).val(1);
            }

            let id = $(this).attr('id').replace('quantity','');
            
            if(parseInt($('#maxorder'+id).val()) < 1){
                swal({
                    title: '',
                    text: 'Sorry. Currently, there is no sufficient stocks for the item you wish to order.',
                    icon: 'warning'
                    });
                $(this).val($('#maxorder'+id).val());
                return false;
            }
            if(parseInt(qty) > parseInt($('#maxorder'+id).val())){
                swal({
                    title: '',
                    text: 'Sorry, you can only order up to '+$('#maxorder'+id).val()+' qty of this product',
                    icon: 'warning'
                    });
                $(this).val($('#maxorder'+id).val());
                return false;
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: { 
                    "quantity": qty, 
                    "record_id": $('#pp'+id).val(), 
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('cart.ajax_update')}}",
                
                success: function(returnData) {
                   
                }
                
            });
          
            update_sub_total_price_per_item(id);

            compute_grand_total();
        });

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

        function collectibles(){
            var hasProduct = $('#cproducts').val();
            if(hasProduct == ''){
                swal({
                    title: '',
                    text: "Your shopping cart is empty. Please add at least one (1) product.",         
                });
                return false;
            }

            var products = $('#cproducts').val();

            let totalAmount = 0;  
            for(x=1;x<={{ $totalProducts }};x++){          
                totalAmount+=parseFloat($('#sum_sub_price'+x).val());
            }

            let totalQty = 0;  
            for(x=1;x<={{ $totalProducts }};x++){          
                totalQty+=parseFloat($('#quantity'+x).val());
            }

            $.ajax({
                type: "GET",
                url: "{{ route('display.collectibles') }}",
                data: { 
                    // 'cproducts' : products.slice(0,-1),
                    'total_amount' : totalAmount,
                    'total_qty' : totalQty
                },
                success: function( response ) {
                    $('#collectibles').empty();

                    var arr_selected_coupons = [];
                    $("input[name='couponid[]']").each(function() {
                        arr_selected_coupons.push(parseInt($(this).val()));
                    });

                    $.each(response.collectibles, function(key, coupon) {
                        if(coupon.availability == 1){
                            if(jQuery.inArray(coupon.id, arr_selected_coupons) !== -1){
                                var btn  = '<span class="text-success" id="couponSpan'+coupon.id+'">Already Use</span>';
                            } else {
                                if(coupon.free_product_id != null){
                                    var btn = '<button type="button" id="couponBtn'+coupon.id+'" class="btn btn-sm btn-primary" onclick="free_product_coupon('+coupon.id+')">Use Now</button>';
                                } else {
                                    var btn = '<button type="button" id="couponBtn'+coupon.id+'" class="btn btn-sm btn-primary" onclick="use_coupon('+coupon.id+')">Use Now</button>';
                                }
                            }
                            
                        } else {
                            var btn = '';
                        }
                        $('#collectibles').append(
                            '<tr>'+
                                '<input type="hidden" id="discountpercentage'+coupon.id+'" value="'+coupon.percentage+'">'+
                                '<input type="hidden" id="discountamount'+coupon.id+'" value="'+coupon.amount+'">'+
                                '<input type="hidden" id="couponname'+coupon.id+'" value="'+coupon.name+'">'+
                                '<input type="hidden" id="couponcode'+coupon.id+'" value="'+coupon.coupon_code+'">'+
                                '<input type="hidden" id="couponterms'+coupon.id+'" value="'+coupon.terms_and_conditions+'">'+
                                '<input type="hidden" id="couponfreeproductid'+coupon.id+'" value="'+coupon.free_product_id+'">'+
                                '<td>'+
                                    '<strong>'+coupon.name+'</strong>'+
                                '</td>'+
                                '<td class="align-middle" width="30%">'+coupon.terms_and_conditions+'</td>'+
                                '<td>'+btn+'<span class="text-success" id="couponSpan'+coupon.id+'" style="display: none;">Already Use</span></td>'+
                            '</tr>'
                        );
                    });

                    $('#total_collectibles').html(response.total_collectibles);

                    $('#exampleModalCenter').modal('show');
                }
            });
        }

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

        function free_product_coupon(cid){
            if(coupon_counter()){
                var name  = $('#couponname'+cid).val();
                var terms = $('#couponterms'+cid).val();
                var freeproductid = $('#couponfreeproductid'+cid).val();

                $('#couponList').append(
                    '<div class="p-3 border-bottom" id="couponDiv'+cid+'">'+
                        '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                        '<p class="float-right cRmvFreeProduct" id="'+cid+'"><a href="#"><i class="fa fa-times"></i></a></p>'+
                        '<p><span class="h5 float-left"><strong>'+name+'</strong></span></p>'+
                        '<div class="clearfix"></div>'+
                        '<input type="hidden" name="coupon_productid[]" value="0">'+
                        '<input type="hidden" name="coupon_freeproductid[]" value="'+freeproductid+'">'+
                        '<p>'+terms+'</p>'+
                    '</div>'
                );

                $('#couponBtn'+cid).css('display','none');
                $('#couponSpan'+cid).css('display','block');
            }
        }

        $(document).on('click', '.cRmvFreeProduct', function(){  
            var id = $(this).attr("id");  
            
            $('#couponBtn'+id).css('display','block');
            $('#couponSpan'+id).css('display','none');

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            $('#couponDiv'+id+'').remove();   
        });
        
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

                compute_grand_total();
            }
        }

        $(document).on('click', '.couponRemove', function(){  
            var id = $(this).attr("id");  
            
            $('#couponBtn'+id).css('display','block');
            $('#couponSpan'+id).css('display','none');

            $('#total_amount_discount').val(0);

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var total_amount_counter = $('#total_amount_discount_counter').val();
            $('#total_amount_discount_counter').val(parseInt(total_amount_counter)-1);

            $('#couponDiv'+id+'').remove();   

            compute_grand_total();
        });

        function choose_product(cid){
            var amount= $('#discountamount'+cid).val();
            var percnt= $('#discountpercentage'+cid).val();

            if(amount > 0){
                var productdiscount = 'amount|'+amount;
            }

            if(percnt > 0){
                var productdiscount = 'percent|'+percnt;
            }

            if({{$totalProducts}} > 1){

                $('#cart_products').empty();
                $(".loop-iteration").each(function() {
                    var id = this.value;

                    var name = $('#product_name_'+id).val();
                    var is_reward = $('#cart_product_reward'+id).val();

                    if(is_reward == 0){
                        $('#cart_products').append(
                            '<tr>'+
                                '<td class="align-middle">'+
                                    '<div class="form-check">'+
                                    '<input type="hidden" id="pname'+id+'" value="'+name+'">'+
                                    '<input type="hidden" id="cid'+id+'" value="'+cid+'">'+
                                    '<input type="hidden" id="cb_discount'+id+'" value="'+productdiscount+'">'+
                                        '<input type="radio" name="cb_product" class="cb" id="cb'+id+'" value="'+id+'">'+
                                    '</div>'+
                                '</td>'+
                                '<td>'+
                                    '<strong>'+name+'</strong>'+
                                '</td>'+
                            '</tr>'
                        );
                    } 
                });

                $('#modalCartProduct').modal('show');
            } else {
                var code  = $('#couponcode'+cid).val();
                var terms = $('#couponterms'+cid).val();
                var amount= $('#discountamount'+cid).val();
                var percnt= $('#discountpercentage'+cid).val();

                if(coupon_counter()){
                    $('#couponBtn'+cid).css('display','none');
                    $('#couponSpan'+cid).css('display','block');

                    $(".loop-iteration").each(function() {
                        var id = this.value;
                        var pname = $('#product_name_'+id).val();
                        var productid = $('#pp'+id).val();

                        $('#couponList').append(
                            '<div class="p-3 border-bottom" id="couponDiv'+cid+'">'+
                                '<input type="hidden" id="productid'+cid+'" value="'+id+'">'+
                                '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                '<p class="float-right productCouponRemove" id="'+cid+'"><a href="#"><i class="fa fa-times"></i></a></p>'+
                                '<p><span class="h5 float-left"><strong>'+code+'</strong></span></p>'+
                                '<div class="clearfix"></div>'+
                                '<p>'+terms+'</p>'+
                                '<input type="hidden" name="coupon_productid[]" value="'+productid+'">'+
                                '<p class="text-success">Applied On : '+pname+'</p>'+
                            '</div>'
                        );


                        var x = productdiscount.split('|');
                        var sub_price = $('#sum_sub_price'+id).val();

                        if(x[0] == 'amount'){
                            var totalDiscount = parseFloat(sub_price)-parseFloat(x[1]);
                            var discount = parseFloat(x[1]);
                        }

                        if(x[1] == 'percent'){
                            var percent = parseFloat(x[1])/100;
                            var discount =  parseFloat(sub_price)*parseFloat(percent);

                            var totalDiscount = parseFloat(sub_price)-parseFloat(discount);
                        }

                        $('#cart_product_discount'+id).val(discount.toFixed(2));
                        $('#sum_sub_price'+id).val(totalDiscount);

                        $('#product_total_price'+id).css({'text-decoration':'line-through','color':'grey'});
                        $('#product_new_price'+id).css('display','block');
                        $('#product_new_price'+id).html('₱ '+addCommas(totalDiscount.toFixed(2))); 

                        $('#cart_product_reward'+id).val(1);

                        compute_grand_total();
                        $('#modalCartProduct').modal('hide');
                    });
                }
            }
        }

        function apply_reward_to_product(){

            if(coupon_counter()){
                var id = $("input:radio[name='cb_product']:checked").val();
                var sub_price = $('#sum_sub_price'+id).val();
                var cid = $('#cid'+id).val();

                var cb_discount = $('#cb_discount'+id).val();
                var x = cb_discount.split('|');

                if(x[0] == 'amount'){
                    var total = parseFloat(sub_price)-parseFloat(x[1]);
                    var discount = parseFloat(x[1]);
                }

                if(x[1] == 'percent'){
                    var percent = parseFloat(x[1])/100;
                    var discount =  parseFloat(sub_price)*parseFloat(percent);

                    var total = parseFloat(sub_price)-parseFloat(discount);
                }

                $('#cart_product_discount'+id).val(discount.toFixed(2));
                $('#sum_sub_price'+id).val(total);
                $('#product_total_price'+id).css({'text-decoration':'line-through','color':'grey'});

                $('#product_new_price'+id).css('display','block');
                $('#product_new_price'+id).html('₱ '+addCommas(total.toFixed(2)));


                var code  = $('#couponcode'+cid).val();
                var terms = $('#couponterms'+cid).val();
                var amount= $('#discountamount'+cid).val();
                var percnt= $('#discountpercentage'+cid).val();
                var pname = $('#pname'+id).val();
                var productid = $('#pp'+id).val();

                $('#couponList').append(
                    '<div class="p-3 border-bottom" id="couponDiv'+cid+'">'+
                        '<input type="hidden" id="productid'+cid+'" value="'+id+'">'+
                        '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                        '<p class="float-right productCouponRemove" id="'+cid+'"><a href="#"><i class="fa fa-times"></i></a></p>'+
                        '<p><span class="h5 float-left"><strong>'+code+'</strong></span></p>'+
                        '<div class="clearfix"></div>'+
                        '<p>'+terms+'</p>'+
                        '<input type="hidden" name="coupon_productid[]" value="'+productid+'">'+
                        '<p class="text-success">Applied On : '+pname+'</p>'+
                    '</div>'
                );

                $('#couponBtn'+cid).css('display','none');
                $('#couponSpan'+cid).css('display','block');
                $('#cart_product_reward'+id).val(1);

                compute_grand_total();
                $('#modalCartProduct').modal('hide');
            }
        }

        // remove coupon applied on products
        $(document).on('click','.productCouponRemove', function(){
            var id = $(this).attr('id'); // coupon id
            var pid = $('#productid'+id).val(); // product iteration id

            var pr = parseFloat($('#quantity'+pid).val()) * parseFloat($('#price'+pid).val());

            $('#sum_sub_price'+pid).val(pr);
            $('#product_new_price'+pid).css('display','none');
            $('#product_total_price'+pid).css({'text-decoration':'','color':'black'});

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            $('#cart_product_reward'+pid).val(0);

            $('#couponDiv'+id+'').remove(); 
            $('#couponBtn'+id).css('display','block');
            $('#couponSpan'+cid).css('display','none');

            compute_grand_total();
        });

        function update_sub_total_price_per_item(id){

            var pr = parseFloat($('#quantity'+id).val()) * parseFloat($('#price'+id).val());
            var discount = $('#cart_product_discount'+id).val();

            if(parseFloat(discount) > 0){
                var total_pr = parseFloat(pr)-parseFloat(discount);
                $('#product_new_price'+id).html('₱ '+ addCommas(total_pr.toFixed(2)));  
            } else {
                var total_pr = pr;
                $('#product_new_price').css('display','none');
                $('#product_total_price'+id).css({'text-decoration':'','color':'black'});
            }
            //$('#total_price'+id).html('Php '+ addCommas(pr.toFixed(2)));
            $('#sum_sub_price'+id).val(total_pr);
            $('#product_total_price'+id).html('₱ '+ addCommas(pr.toFixed(2)));  
        }

        function compute_grand_total(){
            let summary_sub_price = 0;  
            var amountDiscount = parseFloat($('#total_amount_discount').val());

            for(x=1;x<={{ $totalProducts }};x++){          
                summary_sub_price+=parseFloat($('#sum_sub_price'+x).val());
            }

            // total amount discount
            if(amountDiscount > 0){
                var total = parseFloat(summary_sub_price)-amountDiscount;

                $('.promotionDiv').css('display','block');
                $('#total_deduction').html('₱ '+addCommas(amountDiscount.toFixed(2)));
            } else {
                var total = summary_sub_price;
                $('.promotionDiv').css('display','none');
            }

            $('#total_sub').html('₱ '+addCommas(summary_sub_price.toFixed(2)));
            $('#total_grand').html('₱ '+addCommas(total.toFixed(2)));  
        }

        function remove_item(i){
            swal({
                title: 'Are you sure?',
                text: "This will remove the item from your cart",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'            
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('#product_remove_id').val(i);
                    $('#remove_form').submit();
                } 
                else {                    
                    swal.close();                   
                }
            });  
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
