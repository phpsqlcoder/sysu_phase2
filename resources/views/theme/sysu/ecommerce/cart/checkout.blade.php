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
                        <h3 style="font-family:serif;">Payment Summary</h3>
                        <table class="table">
                            <tr>
                                <td>Order:</td>
                                <td align="right">
                                    <input type="hidden" id="order_amount" name="order_amount" value="{{$products->sum('itemTotalPrice')}}">
                                    <input type="hidden" id="delivery_fee" name="delivery_fee" value="0">
                                    <input type="hidden" id="total_amount" name="total_amount" value="{{$products->sum('itemTotalPrice')}}">
                                    &#8369; {{number_format($products->sum('itemTotalPrice'),2)}}</td>
                            </tr>
                            <tr id="delivery_fee_row" style="@if($delivery_fee_text=='0.00') display:none @endif;">
                                <td>Delivery Fee:</td>
                                <td align="right"><span id="delivery_fee_div">{{$delivery_fee_text}}</span></td>
                            </tr>
                            <tr style="font-size:20px;font-weight:bold;">
                                <td>Total:</td>
                                <td align="right">&#8369; <span id="total_amount_div">{{number_format($products->sum('itemTotalPrice'),2)}}</span></td>
                            </tr>
                        </table>                   
                        <div class="gap-20"></div>
                        
                        <div class="form-group text-right">                            
                            
                             <a class="btn btn-info" style="" href="#" id="sbtbtn" onclick="pay_now();">Pay Now</a>
                             <div class="spinner-border text-primary" role="status" style="display:none;" id="sbt_loading">
                                  <span class="sr-only">Loading...</span>
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

@endsection

@section('pagejs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
       
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
        //return false;
    }

    function pay_now() {      
        var st = $('input[name="shipping_type"]:checked').val(); 
        if(st == 'd2d'){
            if($('#location').val()==''){
                //alert('Please select your city.');
                swal({
                    title: '',
                    text: 'Please select your city/province.',
                    icon: 'warning'
                });              
                return false;
            }
        }

        if($('#address_street').val()==''){
            //alert('Please enter Address 1.');
            swal({
                title: '',
                text: 'Please enter Address 1.',
                icon: 'warning'
            });
            return false;
        }

        if($('#address_municipality').val()==''){
            //alert('Please enter Address 2.');
            swal({
                title: '',
                text: 'Please enter Address 2.',
                icon: 'warning'
            });
            return false;
        }

        // if (!$("input[name='shipping_type']").is(':checked')) {
        //    alert('Select your delivery type!');
        //    return false;
        // }

        $('#delivery_address').val($('#address_street').val()+', '+$('#address_municipality').val()+', '+$('#location option:selected').text());
        $('#sbtbtn').hide();
        $('#sbt_loading').show();
        $('#chk_form').submit();

        
        /*
            let data = $('#chk_form').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: data,
                type: "post",
                url: "{{route('cart.temp_sales')}}",
                beforeSend: function(){
                    $("#loading-overlay").show();
                },
                success: function(returnData) {
                    $("#loading-overlay").hide();
                    
                    if (returnData['success']) {
                        window.location.href = "{{route('product.front.list')}}?purchase_complete=1";                    
                    }
                },
                failed: function() {
                    $("#loading-overlay").hide(); 
                }
            });
        */
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
        var total_a = parseFloat($('#order_amount').val()) + parseFloat($('#delivery_fee').val());
        $('#total_amount_div').html(addCommas(parseFloat(total_a).toFixed(2)));
        $('#total_amount').val(total_a);
        $('#deposit').val(total_a);
        $('#dep50').html('(&#8369; '+parseFloat(total_a)/2+')');
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
