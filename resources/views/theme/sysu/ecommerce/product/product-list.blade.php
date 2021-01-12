@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        .product-img{
            padding: 10px 10px 0px 10px !important;
        }
        .product-title{
            font-weight:bold;
            font-family:"Lato", sans-serif !important !important !important;
            font-size:30px;
        }
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

        .product-price span{
            color:#FF5733 !important;
        }
    </style>
@endsection

@section('content')
    <main>
        <section class="mt-4">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="main-banner">
                            {{-- 
                            <div class="slick-slider" id="banner">
                                <div class="banner-wrapper">
                                    <div class="banner-image"><img src="{{ asset('theme/sysu/images/banners/banner1.jpg') }}" /></div>
                                </div>
                                <div class="banner-wrapper">
                                    <div class="banner-image"><img src="{{ asset('theme/sysu/images/banners/banner2.jpg') }}" /></div>
                                </div>
                            </div>
                            --}}
                            <div class="slick-slider" id="banner" style="height: 130px;">
                                <div class="alert alert-danger text-center" role="alert" style="font-size:25px;">
                                   We are currently on soft launch. We ask for your patience and understanding as we continuously improve our service. Please note that we are delivering to Metro Manila, Rizal & selected Bulacan areas only.
                                </div>
                               
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </section>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        </div>
        <span onclick="closeNav()" class="dark-curtain"></span>      
        <section id="listing-wrapper pt-0">
            <div class="container pt-2">
                @if(isset($_GET['purchase_complete']))               
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Thank you for your purchased.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="gap-20"></div>
                @endif
                <div class="breadcrumb dark">
                    <a href="{{route('home')}}">Home</a>
                    <span class="fa default"></span>
                    <a href="{{route('product.front.list')}}"><span class="current">Products</span></a>
                    
                </div>
                
                <div class="gap-20"></div>
                <div class="row">
                    
                    <div class="col-lg-3">
                        
                            <div class="desk-cat pb-5 d-none d-lg-block">
                                
                                <div class="catalog-category">   
                                    
                                    <a href="#" class="btn btn-success btn-sm" onclick="$('#filter_form').submit();">Apply Filter</a>
                                    <a href="#" class="btn btn-success btn-sm" onclick="reset_form();">Clear All</a>
                                    <div class="gap-20"></div> 
                                    <form action="{{ route('product.front.list') }}" id="filter_form" method="GET" class="row">
                                        @csrf
                                        <input type="hidden" name="sort" id="sort" value="@if(request()->has('sort')) {{$request->sort}}  @endif">
                                        <input type="hidden" name="limit" id="limit" value="@if(request()->has('limit')) {{$request->limit}} @else 16 @endif">
                                        <input type="hidden" name="search" value="on">                                    
                                    <div class="catalog-top">
                                        <h3 class="catalog-title">Product Categories</h3>                                       
                                        <fieldset>
                                            
                                            
                                            @if ($categories->count())
                                        
                                                <ul class="catalog-top">
                                                    @foreach ($categories as $category)
                                                        <li>
                                                            <div class="checkbox checkbox-info">
                                                                <input id="category-{{$category->id}}" name="category[]" class="parent-category" value="{{$category->id}}" type="checkbox" 
                                                                @if(request()->has('category') && in_array($category->id, $request->category)) checked="checked" @endif>
                                                                <label for="category-{{$category->id}}" class="small">{{$category->name}}</label>
                                                            </div>
                                                            
                                                            @php $subCategories = $category->child_categories; @endphp
                                                            @if ($subCategories && $subCategories->count())
                                                                <span class="fa fa-chevron-down text-center small"></span>

                                                                <ul>
                                                                    @foreach ($subCategories as $subCategory)
                                                                        <li>
                                                                            <div class="checkbox checkbox-info">
                                                                                <input id="subcategory-{{$category->id}}-{{$subCategory->id}}" name="category[]" class="child-{{$category->id}} child" type="checkbox" value="{{$subCategory->id}}" 
                                                                                @if(request()->has('category') && in_array($subCategory->id, $request->category)) checked="checked" @endif>
                                                                                <label for="subcategory-{{$category->id}}-{{$subCategory->id}}" class="small">{{$subCategory->name}}</label>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                              
                                            @endif                                  
                                                 
                                        </fieldset>
                                    </div>
                                    <div class="catalog-top">
                                        <h3 class="catalog-title">Brand</h3>
                                        <fieldset>                                        
                                            @if ($brands->count())
                                            
                                                <ul class="catalog-top">
                                                    @foreach ($brands as $brand)
                                                        <li>                                                        
                                                            <div class="checkbox checkbox-info">
                                                                <input id="brand-{{$brand->brand}}" name="brand[]" type="checkbox" value="{{$brand->brand}}" 
                                                                @if(request()->has('brand') && in_array($brand->brand, $request->brand)) checked="checked" @endif>
                                                                <label for="brand-{{$brand->brand}}" class="small">{{$brand->brand}}</label>
                                                            </div>                                                  
                                                        </li>
                                                    @endforeach
                                                </ul>
                                              
                                            @endif
                                        </fieldset>
                                    </div>
                                    <div class="catalog-top">
                                        <h3 class="catalog-title">Price</h3>
                                        <fieldset>
                                            <ul class="catalog-top">
                                                <li>
                                                    <div class="checkbox checkbox-info">
                                                        <input name="price[]" id="price1" type="checkbox" value="0-500"
                                                        @if(request()->has('price') && in_array('0-500', $request->price)) checked="checked" @endif
                                                        >
                                                        <label for="price1" class="small">₱ 0 - ₱ 500.00</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-info">
                                                        <input name="price[]" id="price2" type="checkbox" value="501-1000"
                                                        @if(request()->has('price') && in_array('501-1000', $request->price)) checked="checked" @endif>
                                                        <label for="price2" class="small">₱ 501.00 - ₱ 1000.00</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-info">
                                                        <input name="price[]" id="price3" type="checkbox" value="1001-1500">
                                                        <label for="price3" class="small">₱ 1001.00 - ₱ 1500.00</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-info">
                                                        <input name="price[]" id="price4" type="checkbox" value="1501-2000"
                                                        @if(request()->has('price') && in_array('1501-2000', $request->price)) checked="checked" @endif>
                                                        <label for="price4" class="small">₱ 1501.00 - ₱ 2000.00</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-info">
                                                        <input name="price[]" id="price5" type="checkbox" value="2001-100000000"
                                                        @if(request()->has('price') && in_array('2001-100000000', $request->price)) checked="checked" @endif>
                                                        <label for="price5" class="small">₱ 2001.00 > </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </fieldset>
                                    </div>
                                    </form>
                                    <a href="#" class="btn btn-success btn-sm" onclick="$('#filter_form').submit();">Apply Filter</a>
                                    <a href="#" class="btn btn-success btn-sm" onclick="reset_form();">Clear All</a>
                                </div>
                               
                            </div>    
                                            
                    </div>
                    
                    <div class="col-lg-9">
                        <div class="filter-product">
                            <div class="form-row">
                                <div id="col2" class="col-6">
                                
                                    <p class="text-left"><span class="d-none d-lg-block">&nbsp;</span>
                                        <span onclick="openNav()" class="filter-btn d-block d-lg-none"><i class="fa fa-list"></i> Filter</span>
                                    </p>
                                    <div class="gap-10"></div>
                                    <div class="btn-group">
                                        <p class="filter-item-count">Sort: </p>                                        
                                        <button type="button" class="btn dropdown-filter-btn dropdown-toggle mr-lg-auto" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                                @if(request()->has('sort'))
                                                    {{$request->sort ?? 'Sort by'}}
                                                @else
                                                    Sort by
                                                @endif
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" onclick="filter_sort('Price low to high')">Price low to high</a>
                                            <a class="dropdown-item" href="#" onclick="filter_sort('Price high to low')">Price high to low</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="text-right">{{$total_product}} item/s found</p>
                                    <div class="gap-10"></div>
                                    <div class="btn-group">
                                        <p class="filter-item-count ml-auto">Show products:</p>
                                        <button type="button" class="btn dropdown-filter-btn dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                                @if(request()->has('limit'))
                                                    {{$request->limit}}
                                                @else
                                                    40
                                                @endif items
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" onclick="filter_limit('16')">16</a>
                                            <a class="dropdown-item" href="#" onclick="filter_limit('24')">24</a>
                                            <a class="dropdown-item" href="#" onclick="filter_limit('40')">40</a>
                                            <a class="dropdown-item" href="#" onclick="filter_limit('60')">60</a>
                                            <a class="dropdown-item" href="#" onclick="filter_limit('100')">100</a>
                                            <a class="dropdown-item" href="#" onclick="filter_limit('All')">All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="gap-20"></div>
                        <div class="list-product">
                            <div class="row no-gutters">
                                @forelse($products as $product)                                    
                                    <div class="col-lg-3 col-md-4 col-6 item">
                                        <div class="product-link border">
                                            <div class="product-card">
                                               
                                                <a href="{{route('product.front.show',$product->slug)}}" title="{{$product->name}}">
                                                    <div class="product-img">
                                                        <img src="{{ asset('storage/products/'.$product->photoPrimary) }}" alt="" />
                                                    </div>
                                                    <div class="gap-20"></div>
                                                    <p class="product-title px-3">
                                                    {{ str_limit(strip_tags($product->name), 50) }}                                                    
                                                    </p>
                                                </a>
                                                <div class="info position-relative">
                                                    <div class="row no-gutters px-3 pb-3">
                                                        <div class="col-12"><h3 class="product-price">
                                                            <span>₱ {{number_format($product->price,2)}}</span> | {{$product->uom}}</h3>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                                @if($product->Maxpurchase > 0)
                                                    <div class="listing-bottom row no-gutters px-3 pb-3">
                                                        <div>
                                                            @php
                                                                $added_on_cart = \App\EcommerceModel\Cart::is_product_on_cart($product->id);
                                                            @endphp
                                                            
                                                            <div class="shopping-cart-quantity quantity-listing">
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-default btn-number minus-btn" @if($added_on_cart == 0) disabled="disabled" @endif data-type="minus" data-field="quant[{{$loop->iteration}}]">
                                                                            <span class="fa fa-minus"></span>
                                                                        </button>
                                                                    </span>
                                                                    <input type="text" name="quant[{{$loop->iteration}}]" id="qty{{$loop->iteration}}" class="form-control input-number quantity-fld" value="{{$added_on_cart}}" min="0" max="{{$product->Maxpurchase}}">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-default btn-number plus-btn" data-type="plus" data-field="quant[{{$loop->iteration}}]">
                                                                            <span class="fa fa-plus"></span>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="rounded">
                                                            <a href="javascript:void(0)" onclick="add_to_cart({{$product->id}},'qty{{$loop->iteration}}');" id="btn{{$product->id}}">
                                                                @if($added_on_cart <= 0)
                                                                    <i class="fa fa-cart-plus bg-success text-light p-1 rounded"></i>
                                                                @else
                                                                    <i class="fa fa-cart-plus bg-warning text-light p-1 rounded" title="Already added on cart"></i>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="listing-bottom row no-gutters px-3 pb-3">
                                                        <a href="#" class="btn btn-secondary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">Out of Stock</a>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    No Product Found..
                                @endforelse


                                
                                
                            </div>
                        </div>
                        
                        {{ $products->onEachSide(1)->appends($_GET)->links() }}
                       
                        <ul class="pagination" style="display:none;">
                            <li class="page-item">
                                <a class="page-link" href="#" title="Back"><i class="lnr lnr-chevron-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">4</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" title="Next"><i class="lnr lnr-chevron-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        
        
    </main>
    <div id="loading-overlay">
        <div class="loading-icon"></div>
    </div>
    
@endsection

@section('pagejs')
<script src="{{ asset('theme/sysu/plugins/ion.rangeslider/js/ion.rangeSlider.js') }}"></script>
<script src="{{ asset('js/notify.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- <script src="{{ asset('theme/sysu/js/ecommerce.js') }}"></script> -->
<script>
    // $('#filter_form').on('submit',function(){
    //     $("#filter_form :input").each(function(){
    //      console.log($(this).val()); // This is the jquery object of the input, do what you will
    //     });
    //     return false;
    // }); 

    function reset_form(){        
        $('#filter_form').find(':checkbox, :radio').prop('checked', false);
        $('#filter_form').submit(); 
    }

    $('.parent-category').change(function() {  
        if ($(this).prop('checked')) 
            $('.child-' + (this.id).replace('category-','')).prop('checked', true);
        else
            $('.child-' + (this.id).replace('category-','')).prop('checked', false);
        
    });

    $('.child').change(function() {  
        var h = (this.id).split("-");

        if ($(this).prop('checked')){  
            var x = check_if_any_is_unchecked(h[1]);
            if(x == 0){
                $('#category-' +h[1]).prop('checked', true);
            }
            
        }
        else{
            $('#category-' +h[1]).prop('checked', false);
        }
        
    });

    function check_if_any_is_unchecked(i){
        var x = 0;
        $('.child-'+i).each(function() {
            
            if($(this).prop('checked') == true){
               
            }
            else{
                 x = 1;
            }
            
        });     
        return x;     
    }

    function filter_sort(par){

       $('#sort').val(par);
        $('#filter_form').submit(); 

    }

    function filter_limit(par){
        $('#limit').val(par);
        $('#filter_form').submit();     
    }   

    function add_to_cart(product,qty) {

        if($('#'+qty).val() < 1){
            swal({
                title: '',
                text: 'Please specify the item quantity.',
                icon: 'warning'
                });
            return false;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            data: {
                "product_id": product, 
                "qty": $('#'+qty).val(),
                "_token": "{{ csrf_token() }}",
            },
            type: "post",
            url: "{{route('cart.add')}}",
            beforeSend: function(){
                $('#btn'+product).html('<img src="{{asset('img/ajax-loader.gif')}}">');
            },
            success: function(returnData) {
                $("#loading-overlay").hide();
                if (returnData['success']) {

                    $('.cart-counter').html(returnData['totalItems']);
                    $('.counter').html(returnData['totalItems']);

                    $.notify("Product Added to your cart",
                        { 
                            position:"bottom right", 
                            className: "success" 
                        }
                    );
                    $('#btn'+product).html('<i class="fa fa-cart-plus bg-warning text-light p-1 rounded" title="Already added on cart"></i>');
                }
                else{
                    swal({
                        toast: true,
                        position: 'center',
                        title: "Warning!",
                        text: "We have insufficient inventory for this item.",
                        type: "warning",
                        showCancelButton: true,
                        timerProgressBar: true, 
                        closeOnCancel: false
                        
                    });
                }
            },
            failed: function() {
                //$("#loading-overlay").hide(); 
            }
            /*
            beforeSend: function(){
                $("#loading-overlay").show();
            },
            success: function(returnData) {
                $("#loading-overlay").hide();
                if (returnData['success']) {
                    //$('.cart-counter').html(returnData['totalItems']);                    
                   
                    swal({
                        // toast: true,
                        // position: 'bottom-right',
                        // title: "Product Added to your cart!",
                        // type: "success",
                        // //showCancelButton: true,
                        // timerProgressBar: true,
                        // confirmButtonClass: "btn-danger",
                        // confirmButtonText: "View Cart",
                        // cancelButtonText: "Continue Shopping",
                        // closeOnConfirm: false,
                        // closeOnCancel: false,
                        // timer: 1000
                        heading: 'Positioning',
                        title: 'Positioning',
                        text: 'Specify the custom position object or use one of the predefined ones',
                        position: 'bottom-left',
                        stack: false
                        
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            window.location.href = "{{route('cart.front.show')}}";
                        } 
                        else {
                            $('#btn'+product).html('<i class="fa fa-cart-plus bg-warning text-light p-1 rounded" title="Already added on cart"></i>');
                            swal.close();
                            //window.location.href = "{{route('product.front.list')}}";
                           
                        }
                    });
                    
                    
                }
                else{
                    swal({
                        toast: true,
                        position: 'center',
                        title: "Warning!",
                        text: "We have insufficient inventory for this item.",
                        type: "warning",
                        showCancelButton: true,
                        timerProgressBar: true, 
                        closeOnCancel: false
                        
                    });
                }
            },
            failed: function() {
                $("#loading-overlay").hide(); 
            }
            */
        });
    }


</script>
@endsection
