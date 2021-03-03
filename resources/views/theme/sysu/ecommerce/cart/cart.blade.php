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
                                
                                <input type="hidden" id="iteration{{$order->product_id}}" value="{{$loop->iteration}}">
                                <input type="hidden" id="record_id{{$loop->iteration}}" name="record_id[{{$loop->iteration}}]" value="{{$order->id}}">
                                <input type="hidden" name="productid[]" id="pp{{$loop->iteration}}" value="{{$order->product_id}}">
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
                                                    <input type="hidden" data-id="{{$loop->iteration}}" id="sum_sub_price{{$loop->iteration}}" class="sum_sub_price" name="sum_sub_price{{$loop->iteration}}" value="{{number_format($order->product->discountedprice*$order->qty,2,'.','')}}">

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
                                    <div class="cart-table-row">
                                        <div class="cart-table-1-col">
                                            <p class="small font-italic pb-3">Coupon(s) will apply upon checkout</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="couponList">
                                <div id="manual-coupon-details"></div>
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

    @include('theme.sysu.ecommerce.cart.modal')
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
                                        use_coupon_total_amount(returnData.coupon_details['id']);
                                    }
                                } else {
                                    use_coupon_on_product(returnData.coupon_details['id']);
                                }
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

            let totalAmount = 0;  
            let totalQty = 0; 
            for(x=1;x<={{ $totalProducts }};x++){          
                totalAmount+=parseFloat($('#sum_sub_price'+x).val());
                totalQty+=parseFloat($('#quantity'+x).val());
            }

            $.ajax({
                type: "GET",
                url: "{{ route('display.collectibles') }}",
                data: {
                    'total_amount' : totalAmount,
                    'total_qty' : totalQty,
                    'page_name' : 'cart',
                },
                success: function( response ) {
                    $('#collectibles').empty();

                    var arr_selected_coupons = [];
                    $("input[name='couponid[]']").each(function() {
                        arr_selected_coupons.push(parseInt($(this).val()));
                    });

                    var arr_cart_products = [];
                    $("input[name='productid[]']").each(function() {
                        arr_cart_products.push(parseInt($(this).val()));
                    });

                    $.each(response.coupons, function(key, coupon) {
                        if(coupon.end_date == null){
                            var validity = '';  
                        } else {
                            if(coupon.end_time == null){
                                var validity = ' - Valid Till '+coupon.end_date;
                            } else {
                                var validity = ' - Valid Till '+coupon.end_date+' '+coupon.end_time;
                            }
                        }

                        if(jQuery.inArray(coupon.id, response.availability) !== -1){

                            // condition
                                if(jQuery.inArray(coupon.id, arr_selected_coupons) !== -1){
                                    var usebtn = '<button class="btn btn-success btn-sm" disabled>Applied</button>';
                                } else {
                                    if(coupon.amount_discount_type == 1){
                                        if(coupon.free_product_id != null){
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="free_product_coupon('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        } else {
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_total_amount('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        }
                                    } else {
                                        if(coupon.product_discount == 'specific' || coupon.product_discount == 'current'){
                                            
                                            // if(jQuery.inArray(parseInt(coupon.discount_product_id), arr_cart_products) !== -1){
                                            //     var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                            // } else {
                                            //     var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                            // }

                                            if(jQuery.inArray(parseInt(coupon.discount_product_id), arr_cart_products) !== -1){
                                                var iteration = $('#iteration'+coupon.discount_product_id).val();
                                                var cartQty = parseFloat($('#quantity'+iteration).val());
                                                var pqty = parseFloat(coupon.purchase_qty);

                                                if(pqty > 0){
                                                    if(cartQty > pqty){
                                                        var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                                    } else {
                                                        var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                                    }
                                                } else {
                                                    var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                                }
                                                

                                            } else {
                                                var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                            }
                                        } else {
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        }
                                    }
                                }
                            //

                            $('#collectibles').append(
                                '<div class="coupon-item p-2 border rounded mb-1" id="coupondiv'+coupon.id+'">'+
                                    '<div class="row no-gutters">'+
                                        '<div class="col-12">'+
                                            '<input type="hidden" id="remainingusage'+coupon.id+'" value="'+response.remaining[key]+'">'+
                                            '<input type="hidden" id="purchaseqty'+coupon.id+'" value="'+coupon.purchase_qty+'">'+
                                            '<input type="hidden" id="productdiscount'+coupon.id+'" value="'+coupon.product_discount+'">'+
                                            '<input type="hidden" id="discountproductid'+coupon.id+'" value="'+coupon.discount_product_id+'">'+
                                            '<input type="hidden" id="purchaseproductid'+coupon.id+'" value="'+coupon.purchase_product_id+'">'+
                                            '<input type="hidden" id="discountpercentage'+coupon.id+'" value="'+coupon.percentage+'">'+
                                            '<input type="hidden" id="discountamount'+coupon.id+'" value="'+coupon.amount+'">'+
                                            '<input type="hidden" id="couponname'+coupon.id+'" value="'+coupon.name+'">'+
                                            '<input type="hidden" id="couponcode'+coupon.id+'" value="'+coupon.coupon_code+'">'+
                                            '<input type="hidden" id="couponterms'+coupon.id+'" value="'+coupon.terms_and_conditions+'">'+
                                            '<input type="hidden" id="coupondesc'+coupon.id+'" value="'+coupon.description+'">'+
                                            '<input type="hidden" id="couponfreeproductid'+coupon.id+'" value="'+coupon.free_product_id+'">'+
                                            '<div class="coupon-item-name">'+
                                                '<h5 class="m-0">'+coupon.name+' <span>'+validity+'</span></h5>'+
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

                        if(coupon.product_discount == 'specific' || coupon.product_discount == 'current'){
                            if(jQuery.inArray(parseInt(coupon.discount_product_id), arr_cart_products) !== -1){
                                var iteration = $('#iteration'+coupon.discount_product_id).val();
                                var cartQty = parseFloat($('#quantity'+iteration).val());
                                var pqty = parseFloat(coupon.purchase_qty);

                                if(pqty > 0){
                                    if(cartQty > pqty){
                                        
                                    } else {
                                        $('#coupondiv'+coupon.id).addClass('deactivate');
                                    }
                                }

                            } else {
                                $('#coupondiv'+coupon.id).addClass('deactivate');
                            }
                        }

                        $('[data-toggle="popover"]').popover();
                        
                    });
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

    // coupon free products
        function free_product_coupon(cid){
            if(coupon_counter()){
                var name  = $('#couponname'+cid).val();
                var terms = $('#couponterms'+cid).val();
                var desc = $('#coupondesc'+cid).val();
                var freeproductid = $('#couponfreeproductid'+cid).val();

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
                                        '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                        '<input type="hidden" name="coupon_productid[]" value="0">'+
                                        '<input type="hidden" name="coupon_freeproductid[]" value="'+freeproductid+'">'+
                                        '<button type="button" class="btn btn-danger btn-sm cRmvFreeProduct" id="'+cid+'">Remove</button>&nbsp;'+
                                        '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+terms+'">Terms & Conditions</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );

                $('#couponBtn'+cid).prop('disabled',true);
                $('#btnCpnTxt'+cid).html('Applied');
            }
        }

        $(document).on('click', '.cRmvFreeProduct', function(){  
            var id = $(this).attr("id");  

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            $('#couponDiv'+id+'').remove();   
        });
    //
    
    // use coupon on total amount   
        function use_coupon_total_amount(cid){
            var totalAmountDiscountCounter = $('#total_amount_discount_counter').val();
            var name  = $('#couponname'+cid).val();
            var desc = $('#coupondesc'+cid).val();
            var terms = $('#couponterms'+cid).val();

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

                var grandTotal = $('#grandTotal').val();
                var amount= $('#discountamount'+cid).val();
                var percnt= $('#discountpercentage'+cid).val();

                if(amount > 0){ 
                    var amountdiscount = amount;
                }

                if(percnt > 0){
                    var percent  = parseFloat(percnt)/100;
                    var discount = parseFloat(grandTotal)*percent;

                    var amountdiscount = discount;
                }

                $('#total_amount_discount').val(amountdiscount);
                compute_grand_total();
            }
        }

        $(document).on('click', '.couponRemove', function(){  
            var id = $(this).attr("id");  
            
            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var total_amount_counter = $('#total_amount_discount_counter').val();
            $('#total_amount_discount_counter').val(parseInt(total_amount_counter)-1);
            $('#total_amount_discount').val(0);

            $('#couponDiv'+id+'').remove(); 

            compute_grand_total();
        });
    // end use coupon on total amount


    // choose product
        function use_coupon_on_product(cid){
            var amount= $('#discountamount'+cid).val();
            var percnt= $('#discountpercentage'+cid).val();

            var name  = $('#couponname'+cid).val();
            var desc = $('#coupondesc'+cid).val();
            var terms = $('#couponterms'+cid).val();
            var pdiscount = $('#productdiscount'+cid).val();
            var discpuntproductid = parseFloat($('#discountproductid'+cid).val());
            var remaining = parseFloat($('#remainingusage'+cid).val());
            var purchaseqty = parseFloat($('#purchaseqty'+cid).val());

            var discount = 0;

            if(coupon_counter()){
                if(pdiscount == 'current' || pdiscount == 'specific'){
                    var iteration = $('#iteration'+discpuntproductid).val();

                    if(pdiscount == 'specific'){
                        var sub_price = $('#sum_sub_price'+iteration).val();

                        if(amount > 0){
                            var totalDiscount = parseFloat(sub_price)-parseFloat(amount);
                            var discount = parseFloat(amount);
                        }

                        if(percnt > 0){
                            var percent = parseFloat(percnt)/100;
                            var discount =  parseFloat(sub_price)*parseFloat(percent);

                            var totalDiscount = parseFloat(sub_price)-parseFloat(discount);
                        }
                    }

                    if(pdiscount == 'current'){
                        var price = parseFloat($('#price'+iteration).val());
                    
                        var totalpurchaseqty = parseFloat($('#purchaseqty'+cid).val())+1;
                        var purchaseqty = parseFloat($('#purchaseqty'+cid).val());
                        var cartQty = parseFloat($('#quantity'+iteration).val());

                        if(cartQty % 2 == 0){
                            var totalProductCartQty = cartQty;
                        } else {
                            var totalProductCartQty = cartQty-1;
                        }

                        var totalDiscountedProduct = 0;
                        for (i = 1; i <= totalProductCartQty; i++) {
                            if(i == purchaseqty){
                                totalDiscountedProduct++;
                                var purchaseqty = parseInt(purchaseqty)+totalpurchaseqty;
                            }                                 
                        }

                        var i;
                        var totaldiscount = 0;
                        for (i = 1; i <= totalDiscountedProduct; i++) {
                            if(i <= remaining){
                                if(amount > 0){
                                    var tdiscount = price-parseFloat(amount);
                                }

                                if(percnt > 0){
                                    var percent = parseFloat(percnt)/100;
                                    var discount =  price*parseFloat(percent);

                                    var tdiscount = price-parseFloat(discount);
                                } 

                                totaldiscount += tdiscount;
                            }
                        }

                        var sub_price = $('#sum_sub_price'+iteration).val();
                        var totalDiscount = parseFloat(sub_price)-parseFloat(totaldiscount);
                    }
                    
                }

                if(pdiscount == 'highest'){
                    var highest = -Infinity; var iteration;
                    $(".sum_sub_price").each(function() {
                        var id = $(this).data('id');
                        var x = $('#cart_product_reward'+id).val();
                        if(x == 0){
                            highest = Math.max(highest, parseFloat(this.value));
                        }
                    });
                        
                    $(".sum_sub_price").each(function() {
                        if(parseFloat(this.value) == parseFloat(highest.toFixed(2))){
                            iteration = $(this).data('id');
                        }
                    });
                }



                //$('#cart_product_discount'+iteration).val(discount.toFixed(2));
                $('#sum_sub_price'+iteration).val(totalDiscount);

                $('#product_total_price'+iteration).css({'text-decoration':'line-through','color':'grey'});
                $('#product_new_price'+iteration).css('display','block');
                $('#product_new_price'+iteration).html('₱ '+addCommas(totalDiscount.toFixed(2))); 

                $('#cart_product_reward'+iteration).val(1);

                compute_grand_total();



                var pname = $('#product_name_'+iteration).val();
                var productid = $('#pp'+iteration).val();

                if(pdiscount == 'current'){
                    var i;
                    for (i = 1; i <= totalDiscountedProduct; i++) {
                        if(i <= remaining){
                            $('#couponList').append(
                                '<div id="couponDiv'+cid+'">'+
                                    '<div class="coupon-item p-2 border rounded mb-1">'+
                                        '<div class="row no-gutters">'+
                                            '<div class="col-12">'+
                                                '<div class="coupon-item-name">'+
                                                    '<h5 class="m-0">'+name+' <span></span></h5>'+
                                                '</div>'+
                                                '<div class="coupon-item-desc small mb-1">'+
                                                    '<span>'+desc+'</span><br>'+
                                                    '<span class="text-success">Applied On : '+pname+'</span>'+
                                                '</div>'+
                                                '<div class="coupon-item-btns">'+
                                                    '<input type="hidden" id="productid'+cid+'" value="'+iteration+'">'+
                                                    '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                                    '<input type="hidden" name="coupon_productid[]" value="'+productid+'">'+
                                                    '<button type="button" class="btn btn-danger btn-sm productCouponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                                    '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+terms+'">Terms & Conditions</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'
                            );

                            $('[data-toggle="popover"]').popover();
                        }
                    }
                } else {
                    $('#couponList').append(
                        '<div id="couponDiv'+cid+'">'+
                            '<div class="coupon-item p-2 border rounded mb-1">'+
                                '<div class="row no-gutters">'+
                                    '<div class="col-12">'+
                                        '<div class="coupon-item-name">'+
                                            '<h5 class="m-0">'+name+' <span></span></h5>'+
                                        '</div>'+
                                        '<div class="coupon-item-desc small mb-1">'+
                                            '<span>'+desc+'</span><br>'+
                                            '<span class="text-success">Applied On : '+pname+'</span>'+
                                        '</div>'+
                                        '<div class="coupon-item-btns">'+
                                            '<input type="hidden" id="productid'+cid+'" value="'+iteration+'">'+
                                            '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                            '<input type="hidden" name="coupon_productid[]" value="'+productid+'">'+
                                            '<button type="button" class="btn btn-danger btn-sm productCouponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                            '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+terms+'">Terms & Conditions</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    $('[data-toggle="popover"]').popover();
                }
                
                $('#couponBtn'+cid).prop('disabled',true);
                $('#btnCpnTxt'+cid).html('Applied');
            }
        }

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

            compute_grand_total();
        });
    // end choose product

    // update total sub per product
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
    //

    // calculate grand total
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
    //

    // remove product to cart
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
    //

    // amount number format
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
    //
    </script>
@endsection
