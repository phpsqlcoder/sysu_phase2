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
                                @endphp
                                <input type="hidden" id="record_id{{$loop->iteration}}" name="record_id[{{$loop->iteration}}]" value="{{$order->id}}">
                                <input type="hidden" id="pp{{$loop->iteration}}" value="{{$order->product_id}}">
                                <div class="cart-table mb-3">
                                    <div class="cart-table-item">
                                        <div class="cart-table-remove">
                                            <a href="#" onclick="remove_item({{$order->id}});" class="btn btn-primary btn-sm btn-warning">Remove Item</a>
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
                                            <a href="#" class="small mb-2" data-toggle="modal" data-target="#exampleModalCenter"> or click here to  Select from My Coupons</a>
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

                                    <div class="cart-table-row promotionDiv" style="display: none;">
                                        <div class="cart-table-row">
                                            <div class="cart-table-2-col">
                                                <div class="cart-table-2-title text-danger">LESS : Promotion</div>                                  
                                            </div>
                                            <div class="cart-table-2-col">
                                                <div class="cart-table-2-title text-right text-danger" id="total_deduction"></div>                                   
                                            </div>
                                        </div>
                                    </div>

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

    <!-- Modal -->
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
                            <a class="nav-item nav-link" id="nav-multiple-tab" data-toggle="tab" href="#nav-multiple" role="tab" aria-controls="nav-multiple" aria-selected="false">Multiple</a>
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
                                        @forelse($customerCoupons as $coupon)
                                            @if($coupon->details->transaction_limit == 0)
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="form-check">
                                                            <input type="hidden" id="couponcode{{$coupon->coupon_id}}" value="{{$coupon->details->coupon_code}}">
                                                            <input type="hidden" id="couponterms{{$coupon->coupon_id}}" value="{{$coupon->details->terms_and_conditions}}">
                                                            <input type="radio" name="single-options" class="cb" id="cb{{$coupon->coupon_id}}">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <strong>{{$coupon->details->name}}</strong>
                                                    </td>
                                                    <td class="align-middle" width="30%">
                                                        {{$coupon->details->terms_and_conditions    }}
                                                    </td>
                                            @endif
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

                        <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="nav-multiple" role="tabpanel" aria-labelledby="nav-multiple-tab">
                            <div class="table-history" style="overflow-x:auto;">
                                <table class="table table-hover small text-left overflow-auto">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col" class="align-middle text-nowrap" width="10%">
                                                &nbsp;
                                            </th>
                                            <th scope="col" class="align-middle text-nowrap text-center">Coupon Code</th>
                                            <th scope="col" class="align-middle text-nowrap text-center" width="50%">Deal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customerCoupons as $coupon)
                                            @if($coupon->details->transaction_limit == 1)
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="form-check">
                                                            <input type="hidden" id="discountamount{{$coupon->coupon_id}}" value="{{$coupon->details->amount}}">
                                                            <input type="hidden" id="couponcode{{$coupon->coupon_id}}" value="{{$coupon->details->coupon_code}}">
                                                            <input type="hidden" id="couponterms{{$coupon->coupon_id}}" value="{{$coupon->details->terms_and_conditions}}">
                                                            <input type="checkbox" class="cb" id="cb{{$coupon->coupon_id}}">
                                                        </div>  
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <strong>{{$coupon->details->coupon_code}}</strong>
                                                    </td>
                                                    <td class="align-middle" width="30%">
                                                        {{$coupon->details->terms_and_conditions}}
                                                    </td>
                                            @endif
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

                        <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="nav-collectibles" role="tabpanel" aria-labelledby="nav-collectibles-tab">
                            <div class="table-history" style="overflow-x:auto;">
                                <table class="table table-hover small text-left overflow-auto">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col" class="align-middle text-nowrap text-center">Promo Code</th>
                                            <th scope="col" class="align-middle text-nowrap text-center" width="50%">Deal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <strong>SMPICKUP</strong>
                                            </td>
                                            <td class="align-middle" width="30%">
                                                <p class="text-center"><strong>P100 off</strong> </p>
                                                <p class="text-center">minimum spend P399 valid for pick-up from select foodpanda restaurants in SM Malls in Luzon
                                                </p>
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-success">Collect</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <strong>COUPON</strong>
                                            </td>
                                            <td class="align-middle" width="30%">
                                                <p class="text-center"><strong>P100 off</strong> </p>
                                                <p class="text-center">minimum spend P399 valid for pick-up from select foodpanda restaurants in SM Malls in Luzon
                                                </p>
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-success">Collect</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="apply_coupon()">Apply</button>
                </div>
            </div>
        </div>
    </div>
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

            for(x=1;x<={{ $totalProducts }};x++){          
                summary_sub_price+=parseFloat($('#sum_sub_price'+x).val());
            }

            $('#total_sub').html('₱ '+addCommas(summary_sub_price.toFixed(2)));
            $('#total_grand').html('₱ '+addCommas(summary_sub_price.toFixed(2)));  
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

        function update_sub_total_price_per_item(id){

            var pr = parseFloat($('#quantity'+id).val()) * parseFloat($('#price'+id).val());

            $('#total_price'+id).html('Php '+ addCommas(pr.toFixed(2)));
            $('#sum_sub_price'+id).val(pr);
            $('#product_total_price'+id).html('₱ '+ addCommas(pr.toFixed(2)));  
        }

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

        function apply_coupon(){
            var counter = 0;
            var selected_coupons = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_coupons += fid.substring(2, fid.length)+'|';
            });
            if(parseInt(counter) < 1){
                swal({
                    title: '',
                    text: "Please select at least one (1) coupon.",         
                }); 
                return false;
            }
            else{
                if(parseInt(counter) > 3){
                    swal({
                        title: '',
                        text: "Maximum of three (3) coupons only.",         
                    }); 
                    return false;
                } else {
                    var grandTotal = $('#grandTotal').val();
                    var deduction = 0;
                    var coupons = selected_coupons.slice(0,-1);
                    var c = coupons.split('|');

                    $('#couponList').empty();
                    $.each(c, function(key, cid) {

                        var code  = $('#couponcode'+cid).val();
                        var terms = $('#couponterms'+cid).val();
                        var amount= $('#discountamount'+cid).val();

                        $('#couponList').append(
                            '<div class="p-3 border-bottom" id="couponDiv'+cid+'">'+
                                '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                '<p class="float-right couponRemove" id="'+cid+'"><a href="#"><i class="fa fa-times"></i></a></p>'+
                                '<p><span class="h5 float-left"><strong>'+code+'</strong></span></p>'+
                                '<div class="clearfix"></div>'+
                                '<p>'+terms+'</p>'+
                            '</div>'
                        );  

                        if(amount.length !== 0){
                            deduction += Number(amount);
                        }      
                
                    });

                    if(deduction > 0){
                        var total = parseFloat(grandTotal)-parseFloat(deduction);

                        $('.promotionDiv').css('display','block');
                        $('#total_deduction').html('₱ '+addCommas(deduction.toFixed(2)));
                        $('#total_grand').html('₱ '+addCommas(total.toFixed(2)));
                    }
                    

                    $('#exampleModalCenter').modal('hide');
                } 
            }
        }

        $(document).on('click', '.couponRemove', function(){  
            var id = $(this).attr("id");   
            $('#couponDiv'+id+'').remove();  
        });

       


    </script>
@endsection
