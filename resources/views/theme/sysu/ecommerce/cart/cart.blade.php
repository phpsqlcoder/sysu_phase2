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
                                $total_product_discount = 0;
                                $total_orig_price = 0;
                                $total_price_wout_promo = 0;
                                $total = 0;
                                $total_product_count=0;
                                $cproducts  = '';
                            @endphp
                            @forelse($cart as $key => $order)
                                @php
                                    $total_product_count++;
                                    $product = $order->product;
                                    $total += $order->product->discountedprice*$order->qty;
                                    $total_orig_price = $order->product->price*$order->qty;
                                    $max = $product->Maxpurchase;
                                    if (empty($product)) {
                                        continue;
                                    }

                                    $total_price_wout_promo += $total_orig_price;

                                    $product_discount = $order->product->price-$order->product->discountedprice;
                                    $total_product_discount += $product_discount*$order->qty;
                                    $cproducts .= $order->product_id.'|';

                                    $promo_discount_percentage = \App\EcommerceModel\Promo::promo_percentage($order->product_id);
                                @endphp
                                
                                <input type="hidden" id="iteration{{$order->product_id}}" value="{{$loop->iteration}}">
                                <input type="hidden" id="record_id{{$loop->iteration}}" name="record_id[{{$loop->iteration}}]" value="{{$order->id}}">
                                <input type="hidden" name="productid[]" id="pp{{$loop->iteration}}" value="{{$order->product_id}}">
                                <input type="hidden" name="productbrand[]" data-productid="{{$order->product_id}}" id="pp{{$loop->iteration}}" value="{{$order->product->brand}}">
                                <input type="hidden" name="productcatid[]" data-productid="{{$order->product_id}}" id="pp{{$loop->iteration}}" value="{{$order->product->category_id}}">
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
                                                    
                                                    <input type="hidden" class="loop-iteration" id="cart_product_{{$loop->iteration}}" value="{{$loop->iteration}}">
                                                    <input type="hidden" class="cart_product_reward" id="cart_product_reward{{$loop->iteration}}" value="0">
                                                    <input type="hidden" class="cart_product_discount" id="cart_product_discount{{$loop->iteration}}" value="0">

                                                    <input type="hidden" id="product_name_{{$loop->iteration}}" value="{{$product->name}}">
                                                    <input type="hidden" name="price{{$loop->iteration}}" id="price{{$loop->iteration}}" value="{{number_format($product->discountedprice,2,'.','')}}">
                                                    <input type="hidden" data-id="{{$loop->iteration}}" data-productid="{{$order->product_id}}" id="sum_sub_price{{$loop->iteration}}" class="sum_sub_price" name="sum_sub_price{{$loop->iteration}}" value="{{number_format($order->product->discountedprice*$order->qty,2,'.','')}}">

                                                    @if($promo_discount_percentage > 0)
                                                    <div style="font-weight:bold;color:grey;font-size:15px;">Before : ₱ 
                                                        <span id="priceBefore{{$loop->iteration}}">{{ number_format($total_orig_price,2) }}</span>
                                                    </div>
                                                    @endif

                                                    @if($promo_discount_percentage > 0)
                                                    <div style="font-weight:bold;font-size:15px;">
                                                        <span class="text-danger">Promo Discount : {{$promo_discount_percentage}}% OFF</span>
                                                    </div>
                                                    @endif

                                                    <div class="text-danger couponDiscountSpan{{$loop->iteration}}" style="font-weight:bold;display: none;font-size:15px;">
                                                        Coupon Discount :
                                                        <span class="text-danger" id="product_coupon_discount{{$loop->iteration}}"></span>&nbsp;OFF
                                                    </div>

                                                    <div class="prod-total" id="product_total_price{{$loop->iteration}}" style="font-weight:bold;">Total ₱ {{number_format($order->product->discountedprice*$order->qty,2)}}</div>
                                                    <div class="prod-total prod_new_price" id="product_new_price{{$loop->iteration}}" style="font-weight:bold;"></div>

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
                                            @if(Auth::check())
                                            <a href="#" class="small mb-2" onclick="collectibles()"> or click here to  Select from My Coupons</a>
                                            @else
                                            <a href="#" class="small mb-2" onclick="login_modal()"> or click here to  Select from My Coupons</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="cart-table-row">
                                        <div class="cart-table-1-col">
                                            <p class="small font-italic pb-3">Coupon(s) will apply upon checkout</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="couponList"></div>
                            <div id="manual-coupon-details"></div>

                            <input type="hidden" id="coupon_limit" value="{{ Setting::info()->coupon_limit }}">
                            <input type="hidden" id="coupon_counter" name="coupon_counter" value="0">
                            <input type="hidden" id="solo_coupon_counter" value="0">
                            <input type="hidden" id="total_amount_discount_counter" value="0">
                            
                            <div class="mb-5">
                                <h3 class="catalog-title">Summary</h3>

                                <div class="cart-table-2">
                                    <div class="cart-table-row">
                                        <div class="cart-table-2-col">
                                            <div class="cart-table-2-title">Subtotal</div>                                  
                                        </div>
                                        <div class="cart-table-2-col">
                                            <input type="hidden" id="subtotal" value="{{$total_price_wout_promo}}">
                                            <div class="cart-table-2-title text-right" id="total_sub">₱ {{number_format($total_price_wout_promo,2)}}</div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="promo_total_discount" value="{{ $total_product_discount }}">
                                    @if($total_product_discount)
                                    <div class="cart-table-row">
                                        <div class="cart-table-2-col">
                                            <div class="cart-table-2-title text-danger">Promo Discount</div>                                  
                                        </div>
                                        <div class="cart-table-2-col">
                                            <div class="cart-table-2-title text-right text-danger">₱ <span id="span_promo_discount">{{number_format($total_product_discount,2)}}</span></div>
                                        </div>
                                    </div>
                                    @endif

                                    
                                    <input type="hidden" id="coupon_total_discount" name="coupon_total_discount" value="0">
                                    <div class="cart-table-row couponDiscountDiv" style="display: none;">
                                        <div class="cart-table-row">
                                            <div class="cart-table-2-col">
                                                <div class="cart-table-2-title text-danger">Coupon Discount</div>                                  
                                            </div>
                                            <div class="cart-table-2-col">
                                                <div class="cart-table-2-title text-right text-danger" id="total_coupon_deduction"></div>     
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="total_amount_discount" value="0">
                                    <div class="cart-table-row">
                                        <div class="cart-table-2-col">
                                            <div class="cart-table-2-title"><strong>GRAND TOTAL</strong></div>
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

                    var priceBefore = parseFloat(returnData.price_before);
                    $('#priceBefore'+id).html(addCommas(priceBefore.toFixed(2)));

                    var promo_discount = parseFloat(returnData.total_promo_discount);
                    $('#span_promo_discount').html(addCommas(promo_discount.toFixed(2)));
                    $('#promo_total_discount').val(promo_discount.toFixed(2));
                    $('#subtotal').val(returnData.subtotal);

                    $('#couponList').empty();
                    $('#manual-coupon-details').empty();
                    $('.prod_new_price').hide();
                    $('#coupon_counter').val(0);
                    $('#solo_coupon_counter').val(0);
                    $('#total_amount_discount_counter').val(0);
                    $('#coupon_total_discount').val(0);

                    $('#total_amount_discount').val(0);
                    $('.couponDiscountDiv').hide();



                    $(".cart_product_reward").each(function() {
                        $(this).val(0);
                    });

                    $(".cart_product_discount").each(function() {
                        $(this).val(0);
                    });

                    update_sub_total_price_per_item(id);

                    compute_grand_total();
                }
            });

        });

        $('#couponManualBtn').click(function(){
            var couponCode = $('#coupon_code').val();
            var grandtotal = parseFloat($('#grandTotal').val());

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
                        if(returnData.coupon_details['location'] != null){
                            swal({
                                title: '',
                                text: "Shipping fee coupons can only be used on checkout.",         
                            });
                            return false;
                        }

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

                            use_coupon_on_product(returnData.coupon_details['id']);
                        }
                    }  
                }
            });
        });

        function login_modal(){
            $('#modalLoginLink').modal('show');
        }

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

                    // array selected coupon : used to check if coupon is already selected
                        var arr_selected_coupons = [];
                        $("input[name='couponid[]']").each(function() {
                            arr_selected_coupons.push(parseInt($(this).val()));
                        });
                    //

                    // array cart product id, brand, category
                        var arr_cart_products = [];
                        $("input[name='productid[]']").each(function() {
                            arr_cart_products.push(parseInt($(this).val()));
                        });

                        var arr_cart_brands = [];
                        $("input[name='productbrand[]']").each(function() {
                            if($(this).val() != ''){
                                arr_cart_brands.push($(this).val());
                            }
                        });

                        var arr_cart_categories = [];
                        $("input[name='productcatid[]']").each(function() {
                            arr_cart_categories.push(parseInt($(this).val()));
                        });
                    //

                    $.each(response.coupons, function(key, coupon) {
                        // coupon validity label
                            if(coupon.end_date == null){
                                var validity = '';  
                            } else {
                                if(coupon.end_time == null){
                                    var validity = ' - Valid Till '+coupon.end_date;
                                } else {
                                    var validity = ' - Valid Till '+coupon.end_date+' '+coupon.end_time;
                                }
                            }
                        //
                        

                        if(jQuery.inArray(coupon.id, response.availability) !== -1){ 
                            // condition
                                if(jQuery.inArray(coupon.id, arr_selected_coupons) !== -1){
                                    var usebtn = '<button class="btn btn-success btn-sm" disabled>Applied</button>';
                                } else {
                                    if(coupon.amount_discount_type == 1){
                                        var qty_counter = 0;
                                        if(coupon.free_product_id != null){
                                            qty_counter++;
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="free_product_coupon('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        } else {
                                            qty_counter++;
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_total_amount('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        }
                                    } else {

                                        if(coupon.product_discount == 'current'){
                                            // products
                                                if(coupon.purchase_product_id != null){

                                                    var product_counter = 0;
                                                    var arr_purchase_products = [];
                                                    var product_split = coupon.purchase_product_id.split('|');

                                                    // check if customer buys product under set products
                                                    $.each(product_split, function(key, productID) {
                                                        if(productID != ''){
                                                            arr_purchase_products.push(parseInt(productID));    
                                                        }
                                                        
                                                        if(jQuery.inArray(parseInt(productID), arr_cart_products) !== -1){
                                                            product_counter++;
                                                        }
                                                    });

                                                    if(product_counter > 0){
                                                        var qty_counter = 0;
                                                        // each cart product
                                                        $.each(arr_cart_products, function(key, product) {

                                                            if(jQuery.inArray(parseInt(product), arr_purchase_products) !== -1){
                                                                var iteration = $('#iteration'+parseInt(product)).val();
                                                                var product_qty = $('#quantity'+iteration).val();
                                                                // total amount purchase

                                                                // total qty purchase
                                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                                if(product_qty > parseFloat(coupon.purchase_qty)){
                                                                    qty_counter++;
                                                                }
                                                            }
                                                        });

                                                        if(qty_counter > 0){
                                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                                        } else {
                                                            var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                                        }
                                                    }
                                                }
                                            //

                                            // product categories
                                                if(coupon.purchase_product_cat_id != null){
                                                    var category_counter = 0;
                                                    var arr_purchase_categories = [];
                                                    var category_split = coupon.purchase_product_cat_id.split('|');

                                                    // check if customer buys product under set category
                                                    $.each(category_split, function(key, value) {
                                                        if(value != ''){
                                                            arr_purchase_categories.push(parseInt(value));    
                                                        }
                                                        
                                                        if(jQuery.inArray(parseInt(value), arr_cart_categories) !== -1){
                                                            category_counter++;
                                                        }
                                                    });

                                                    if(category_counter > 0){
                                                        var qty_counter = 0;
                                                        // each cart category
                                                        $.each(response.cart_per_category, function(key, category) {

                                                            if(jQuery.inArray(parseInt(category), arr_purchase_categories) !== -1){
                                                                var category_qty = response.cart_qty_per_category[key];
                                                                // total amount purchase

                                                                // total qty purchase
                                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                                if(category_qty > parseFloat(coupon.purchase_qty)){
                                                                    qty_counter++;
                                                                }
                                                            }
                                                        });

                                                        if(qty_counter > 0){
                                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                                        } else {
                                                            var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                                        }
                                                    }
                                                }
                                            //

                                            // product brands
                                                if(coupon.purchase_product_brand != null){
                                                    var brand_counter = 0;
                                                    var arr_purchase_brands = [];
                                                    var brand_split = coupon.purchase_product_brand.split('|');

                                                    // check if customer buys product under set category
                                                    $.each(brand_split, function(key, brand) {
                                                        if(brand != ''){
                                                            arr_purchase_brands.push(brand);    
                                                        }
                                                        
                                                        if(jQuery.inArray(brand, response.cart_per_brand) !== -1){
                                                            brand_counter++;
                                                        }
                                                    });

                                                    if(brand_counter > 0){
                                                        var qty_counter = 0;
                                                        // each cart brand
                                                        $.each(response.cart_per_brand, function(key, brand) {

                                                            if(jQuery.inArray(brand, arr_purchase_brands) !== -1){
                                                                var brand_qty = response.cart_qty_per_brand[key];
                                                                // total amount purchase

                                                                // total qty purchase
                                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                                if(brand_qty > parseFloat(coupon.purchase_qty)){
                                                                    qty_counter++;
                                                                }
                                                            }
                                                        });

                                                        if(qty_counter > 0){
                                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                                        } else {
                                                            var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                                        }
                                                    }
                                                }
                                            //
                                        }

                                        if(coupon.product_discount == 'specific'){
                                            var product_counter = 0;
                                            // check if customer buys product under set category
                                            if(jQuery.inArray(parseInt(coupon.discount_product_id), arr_cart_products) !== -1){
                                                product_counter++;
                                            }

                                            if(product_counter > 0){
                                                var qty_counter = 0;

                                                var iteration = $('#iteration'+parseInt(coupon.discount_product_id)).val();
                                                var product_qty = $('#quantity'+iteration).val();
                                                // total amount purchase

                                                // total qty purchase
                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                if(product_qty > parseFloat(coupon.purchase_qty)){
                                                    qty_counter++;
                                                }

                                                if(qty_counter > 0){
                                                    var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                                } else {
                                                    var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                                }
                                            }
                                        }
                                    }
                                }
                            //

                            if(qty_counter > 0){
                                $('#collectibles').append(
                                    '<div class="coupon-item p-2 border rounded mb-1" id="coupondiv'+coupon.id+'">'+
                                        '<div class="row no-gutters">'+
                                            '<div class="col-12">'+
                                                '<input type="hidden" id="couponproducts'+coupon.id+'" value="'+coupon.purchase_product_id+'">'+
                                                '<input type="hidden" id="couponcategories'+coupon.id+'" value="'+coupon.purchase_product_cat_id+'">'+
                                                '<input type="hidden" id="couponbrands'+coupon.id+'" value="'+coupon.purchase_product_brand+'">'+

                                                '<input type="hidden" id="couponcombination'+coupon.id+'" value="'+coupon.combination+'">'+
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

    // coupon free products
        function free_product_coupon(cid){
            if(coupon_counter(cid)){
                var name  = $('#couponname'+cid).val();
                var terms = $('#couponterms'+cid).val();
                var desc = $('#coupondesc'+cid).val();
                var freeproductid = $('#couponfreeproductid'+cid).val();
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
                                        '<input type="hidden" name="couponUsage[]" value="0">'+
                                        '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
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

            var combination = $('#coupon_combination'+id).val();
            if(combination == 0){
                $('#solo_coupon_counter').val(0);
            }

            $('#couponDiv'+id+'').remove();   
        });
    //
    
    // use coupon on total amount   
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
                                        '<input type="hidden" name="couponUsage[]" value="0">'+
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

                var grandTotal = $('#grandTotal').val();
                var amount= $('#discountamount'+cid).val();
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
                $('#total_coupon_deduction').html('₱ '+addCommas(total_coupon_deduction.toFixed(2))); 
                $('.couponDiscountDiv').css('display','block');

                $('#total_amount_discount').val(amountdiscount);

                compute_grand_total();
            }
        }

        $(document).on('click', '.couponRemove', function(){  
            var id = $(this).attr("id"); 

            var coupon_total_discount = parseFloat($('#coupon_total_discount').val());
            var total_amount_discount = $('#total_amount_discount').val();
            
            var updated_coupon_discount = coupon_total_discount-total_amount_discount;
            $('#coupon_total_discount').val(updated_coupon_discount.toFixed(2));
            $('#total_coupon_deduction').html('₱ '+ addCommas(updated_coupon_discount.toFixed(2))); 
            
            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var total_amount_counter = $('#total_amount_discount_counter').val();
            $('#total_amount_discount_counter').val(parseInt(total_amount_counter)-1);
            $('#total_amount_discount').val(0);

            var combination = $('#coupon_combination'+id).val();
            if(combination == 0){
                $('#solo_coupon_counter').val(0);
            }

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
            var discountproductid = parseFloat($('#discountproductid'+cid).val());
            var remaining = parseFloat($('#remainingusage'+cid).val());
            var purchaseqty = parseFloat($('#purchaseqty'+cid).val());

            var discount = 0;

            if(coupon_counter(cid)){
                if(pdiscount == 'specific'){
                    var iteration = $('#iteration'+discountproductid).val();
                    //var total_cart_reward = parseFloat($('#cart_product_reward'+iteration).val())

                    var pname = $('#product_name_'+iteration).val();
                    var productid = $('#pp'+iteration).val();
                    var combination = $('#couponcombination'+cid).val();

                    var sub_price = $('#sum_sub_price'+iteration).val();

                    if(amount > 0){
                        var productSubTotalDiscount = parseFloat(sub_price)-parseFloat(amount);
                        var discount = parseFloat(amount);
                    }

                    if(percnt > 0){
                        var percent = parseFloat(percnt)/100;
                        var discount =  parseFloat(sub_price)*parseFloat(percent);

                        var productSubTotalDiscount = parseFloat(sub_price)-parseFloat(discount);
                    }

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
                                            '<input type="hidden" name="couponUsage[]" value="1">'+
                                            '<input type="hidden" id="coupon_discount'+cid+'" value="'+discount+'">'+
                                            '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
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
                    $('#cart_product_reward'+iteration).val(1);
                }

                if(pdiscount == 'current'){

                    var products = $('#couponproducts'+cid).val();
                    var categories = $('#couponcategories'+cid).val();
                    var brands = $('#couponbrands'+cid).val();

                    if(products != ''){
                        var product_split = products.split('|');

                        var arr_purchase_products = [];
                        $.each(product_split, function(key, productID) {
                            if(productID != ''){
                                arr_purchase_products.push(parseInt(productID));    
                            }
                        });

                        var exist_counter = 0;
                        var arr_exist_product = [];
                        $("input[name='productid[]']").each(function() {
                            if(jQuery.inArray(parseInt($(this).val()), arr_purchase_products) !== -1){
                                arr_exist_product.push(parseInt($(this).val()));
                                exist_counter++
                            }
                        });

                        if(exist_counter > 0){
                            // get highest product purchase
                            var highest = -Infinity; 
                            var iteration;

                            $(".sum_sub_price").each(function() {
                                var id = $(this).data('id');
                                var productid = $(this).data('productid');

                                var x = $('#cart_product_reward'+id).val();
                                if(x == 0){
                                    if(jQuery.inArray(parseInt(productid), arr_exist_product) !== -1){
                                        highest = Math.max(highest, parseFloat(this.value));
                                    }
                                }
                            });
                                
                            $(".sum_sub_price").each(function() {
                                if(parseFloat(this.value) == parseFloat(highest.toFixed(2))){
                                    iteration = $(this).data('id');
                                }
                            });
                        }
                    }

                    if(categories != ''){
                        var category_split = categories.split('|');

                        var arr_purchase_categories = [];
                        $.each(category_split, function(key, brand) {
                            if(brand != ''){
                                arr_purchase_categories.push(brand);    
                            }
                        });

                        var exist_counter = 0;
                        var arr_exist_product = [];
                        $("input[name='productcatid[]']").each(function() {
                            if(jQuery.inArray($(this).val(), arr_purchase_categories) !== -1){
                                arr_exist_product.push(parseInt($(this).data('productid')));
                                exist_counter++
                            }
                        });

                        if(exist_counter > 0){
                            // get highest product purchase
                            var highest = -Infinity; 
                            var iteration;

                            $(".sum_sub_price").each(function() {
                                var id = $(this).data('id');
                                var productid = $(this).data('productid');

                                var x = $('#cart_product_reward'+id).val();
                                if(x == 0){
                                    if(jQuery.inArray(parseInt(productid), arr_exist_product) !== -1){
                                        highest = Math.max(highest, parseFloat(this.value));
                                    }
                                }
                            });
                                
                            $(".sum_sub_price").each(function() {
                                if(parseFloat(this.value) == parseFloat(highest.toFixed(2))){
                                    iteration = $(this).data('id');
                                }
                            });
                        }
                    }

                    if(brands != ''){
                        var brand_split = brands.split('|');

                        var arr_purchase_brands = [];
                        $.each(brand_split, function(key, brand) {
                            if(brand != ''){
                                arr_purchase_brands.push(brand);    
                            }
                        });

                        var exist_counter = 0;
                        var arr_exist_product = [];
                        $("input[name='productbrand[]']").each(function() {
                            if(jQuery.inArray($(this).val(), arr_purchase_brands) !== -1){
                                arr_exist_product.push(parseInt($(this).data('productid')));
                                exist_counter++
                            }
                        });

                        if(exist_counter > 0){
                            // get highest product purchase
                            var highest = -Infinity; 
                            var iteration;

                            $(".sum_sub_price").each(function() {
                                var id = $(this).data('id');
                                var productid = $(this).data('productid');

                                var x = $('#cart_product_reward'+id).val();
                                if(x == 0){
                                    if(jQuery.inArray(parseInt(productid), arr_exist_product) !== -1){
                                        highest = Math.max(highest, parseFloat(this.value));
                                    }
                                }
                            });
                                
                            $(".sum_sub_price").each(function() {
                                if(parseFloat(this.value) == parseFloat(highest.toFixed(2))){
                                    iteration = $(this).data('id');
                                }
                            });
                        }
                    }
                    
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

                    var pname = $('#product_name_'+iteration).val();
                    var productid = $('#pp'+iteration).val();
                    var combination = $('#couponcombination'+cid).val();

                    var counter = 0;
                    for (i = 1; i <= totalDiscountedProduct; i++) {
                        if(amount > 0){
                            var tdiscount = price-parseFloat(amount);
                        }

                        if(percnt > 0){
                            var percent = parseFloat(percnt)/100;
                            var discount =  price*parseFloat(percent);

                            var tdiscount = price-parseFloat(discount);
                        } 

                        totaldiscount += tdiscount;
                        discount = totaldiscount;
                        counter++;
                    }

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
                                            '<input type="hidden" name="couponUsage[]" value="'+counter+'">'+
                                            '<input type="hidden" id="coupon_discount'+cid+'" value="'+tdiscount+'">'+
                                            '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
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

                    var sub_price = $('#sum_sub_price'+iteration).val();
                    var productSubTotalDiscount = parseFloat(sub_price)-parseFloat(totaldiscount);
                }

                // Total Amount Coupon Discount 
                    var coupon_discount = parseFloat($('#coupon_total_discount').val());

                    var total_coupon_deduction = coupon_discount+discount;
                    $('#coupon_total_discount').val(total_coupon_deduction.toFixed(2));
                    $('#total_coupon_deduction').html('₱ '+addCommas(total_coupon_deduction.toFixed(2))); 
                    $('.couponDiscountDiv').css('display','block');
                //


                // Total Summary Computation
                    $('#cart_product_discount'+iteration).val(discount.toFixed(2));
                    $('#product_coupon_discount'+iteration).html('₱ '+addCommas(discount.toFixed(2)));
                    $('.couponDiscountSpan'+iteration).css('display','block');

                    $('#sum_sub_price'+iteration).val(productSubTotalDiscount.toFixed(2));

                    $('#product_total_price'+iteration).css('display','none');
                    $('#product_new_price'+iteration).css('display','block');
                    $('#product_new_price'+iteration).html('₱ '+addCommas(productSubTotalDiscount.toFixed(2))); 

                    compute_grand_total();
                //

                $('#cart_product_reward'+iteration).val(1);
                $('#couponBtn'+cid).prop('disabled',true);
                $('#btnCpnTxt'+cid).html('Applied');
            }
        }

        $(document).on('click','.productCouponRemove', function(){
            var id = $(this).attr('id'); // coupon id
            var pid = $('#productid'+id).val(); // product iteration id

            var product_subtotal = parseFloat($('#sum_sub_price'+pid).val());
            var total_reward_on_product = $('#cart_product_reward'+pid).val();
            var discount = $('#coupon_discount'+id).val();

            var coupon_total_discount = parseFloat($('#coupon_total_discount').val());
            var coupon_product_discount = parseFloat($('#cart_product_discount'+pid).val());
            
            var updated_coupon_discount = coupon_total_discount-coupon_product_discount;
            $('#coupon_total_discount').val(updated_coupon_discount.toFixed(2));
            $('#total_coupon_deduction').html('₱ '+ addCommas(updated_coupon_discount.toFixed(2))); 

            $('#cart_product_reward'+pid).val(0);
            $('#cart_product_discount'+pid).val(0);

            $('#product_new_price'+pid).css('display','none');
            $('#product_total_price'+pid).css('display','block');
            $('.couponDiscountSpan'+pid).css('display','none');

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var combination = $('#coupon_combination'+id).val();
            if(combination == 0){
                $('#solo_coupon_counter').val(0);
            }

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
            $('#sum_sub_price'+id).val(total_pr.toFixed(2));
            $('#product_total_price'+id).html('Total ₱ '+ addCommas(pr.toFixed(2)));  
        }
    //

    // calculate grand total
        function compute_grand_total(){
            let summary_sub_price = 0;  
            var subtotal = parseFloat($('#subtotal').val());
            var promoTotalDiscount = parseFloat($('#promo_total_discount').val());
            var couponTotalDiscount = parseFloat($('#coupon_total_discount').val());
            

            // for(x=1;x<={{ $totalProducts }};x++){          
            //     summary_sub_price+=parseFloat($('#sum_sub_price'+x).val());
            // }

            if(couponTotalDiscount == 0){
                $('.couponDiscountDiv').css('display','none');
            }

            var totalDeduction = promoTotalDiscount+couponTotalDiscount;
            var grandTotal = subtotal-totalDeduction;

            
            $('#total_sub').html('₱ '+addCommas(subtotal.toFixed(2)));
            $('#grandTotal').val(grandTotal.toFixed(2));
            $('#total_grand').html('₱ '+addCommas(grandTotal.toFixed(2)));  
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
