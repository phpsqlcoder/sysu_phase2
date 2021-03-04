@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">    
<link rel="stylesheet" href="https://raw.githubusercontent.com/kartik-v/bootstrap-star-rating/master/css/star-rating.min.css">

<style>
    .star-rating {
        line-height:32px;
        font-size:1.25em;
    }

    .star-rating .fa-star{color: orange;}
</style>
@endsection

@section('content')
<main>
    <section id="listing-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb dark">
                        <a href="{{route('home')}}">Home</a>
                        <span class="fa default"></span>
                        <a href="{{route('product.front.list')}}">Products</a>
                        <span class="fa default"></span>
                        <a href="{{route('product.front.list')}}?type=category&criteria={{$product->category_id}}">{{$product->category->name ?? 'Uncategorized'}}</a>
                        <span class="fa default"></span>
                        <span class="current">{{ucwords($product->name)}}</span>
                    </div>
                    <div class="gap-20"></div>

                    <div class="product-wrap">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">                                    
                                <div class="xzoom-container">
                                    <img class="xzoom" id="xzoom-default" src="{{  asset('storage/products/'.$product->photoPrimary) }}"
                                    xoriginal="{{ $product->zoom_image }}" />
                                </div>
                                <div id="product-gallery-slider" class="slick-slider">
                                    @foreach($product->photos as $photo)
                                        <a href="{{ asset('storage/products/'.$photo->path) }}" class="xzoom-link"><img class="xzoom-gallery" src="{{ asset('storage/products/'.$photo->path) }}" alt="{{$product->id}}"></a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <form id="addToCart" data-source="addToCart">
                                    <div class="product-detail">
                                        <div class="product-description">
                                            <h2>{{ucwords($product->name)}}</h2>
                                            <div class="product-price mb-4">
                                                @if(\App\EcommerceModel\Product::onsale_checker($product->id) > 0)
                                                    <input type="hidden" id="product_price" value="{{ $product->discountedprice }}">
                                                    <span class="price-after">₱ {{ number_format($product->discountedprice,2) }}</span>
                                                    <span class="price-before">
                                                        <div class="price-less">{{ $product->promodiscount }}% OFF</div>
                                                        <div class="price-original">₱ {{ $product->PriceWithCurrency }}</div>
                                                    </span>
                                                @else
                                                    <input type="hidden" id="product_price" value="{{ $product->price }}">
                                                    <span class="price-after">₱ {{ $product->PriceWithCurrency }}</span>
                                                @endif
                                            </div>
                                            <p>{!! $product->short_description !!}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-2">
                                <div class="product-detail m-0">
                                    @if($product->Maxpurchase > 0)
                                        <div class="w-100">
                                            <div class="product-info">
                                                <div class="container p-0">
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-12 col-md-9 col-6">
                                                            <label for="quantity">Quantity</label>
                                                            @php
                                                            $added_on_cart = \App\EcommerceModel\Cart::is_product_on_cart($product->id);
                                                            @endphp
                                                            <div class="shopping-cart-quantity">
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-default btn-number minus-btn" @if($added_on_cart == 0) disabled="disabled" @endif data-type="minus" data-field="quant[1]">
                                                                            <span class="fa fa-minus"></span>
                                                                        </button>
                                                                    </span>
                                                                    <input type="text" name="quant[1]" id="qty1" class="form-control input-number quantity-fld" value="{{$added_on_cart}}" min="0" max="{{$product->Maxpurchase}}">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-default btn-number plus-btn" data-type="plus" data-field="quant[1]">
                                                                            <span class="fa fa-plus"></span>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <button onclick="clear_qty();" class="clear-btn mt-3" type="reset">Clear Selection</button>
                                                        </div>

                                                        <div class="col-lg-12 col-md-3 col-6">
                                                            <div class="">
                                                                <button id="b3" type="button" onclick="add_to_cart('{{$product->id}}','qty1');" class="btn btn-lg add-cart-alt2-btn addToCartButton btn-block" data-loading-text="processing...">
                                                                    <i class="fa fa-shopping-cart"></i> Add to cart
                                                                </button>
                                                                @php
                                                                    $is_fav      = \App\EcommerceModel\CustomerFavorite::is_favorite($product->id);
                                                                @endphp

                                                                @if(Auth::check())
                                                                    <button style="display: {{ $is_fav == 0 ? 'none' : 'block' }};" id="favBtnRemove" type="button" class="btn btn-warning btn-block" data-loading-text="processing..." onclick="remove_to_favorites('{{$product->id}}')">
                                                                        <i class="fa fa-heart"></i> Remove to favorites
                                                                    </button>

                                                                    <button style="display: {{ $is_fav == 1 ? 'none' : 'block' }};" id="favBtnAdd" type="button" class="btn btn-success btn-block" data-loading-text="processing..." onclick="add_to_favorites('{{$product->id}}')">
                                                                        <i class="fa fa-heart"></i> Add to favorites
                                                                    </button>
                                                                @endif                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @php
                                            $is_wishlist = \App\EcommerceModel\CustomerWishlist::is_wishlist($product->id);
                                        @endphp

                                        <button id="b3" type="button" class="btn btn-secondary btn-block" data-loading-text="processing..." disabled>
                                            <i class="fa fa-times"></i> Out of Stock
                                        </button>

                                        <button style="display: {{ $is_wishlist == 0 ? 'none' : 'block' }};" id="wishlistBtnRemove" type="button" class="btn btn-warning btn-block" onclick="remove_to_wishlist('{{$product->id}}')">
                                            <i class="fa fa-star"></i> Remove to wislist
                                        </button>

                                        <button style="display: {{ $is_wishlist == 1 ? 'none' : 'block' }};" id="wishlistBtnAdd" type="button" class="btn wishlist-btn" onclick="add_to_wishlist('{{$product->id}}')">
                                            <i class="fa fa-star"></i> Add to wishlist
                                        </button>

                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="gap-60"></div>
                    <div class="product-additional">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="synopsis-tab" data-toggle="tab" href="#synopsis" role="tab"
                                aria-controls="synopsis" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail"
                                aria-selected="false">Details about the product</a>
                            </li>
                            @if(Setting::info()->review_is_allowed > 0)
                            <li class="nav-item">
                                <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
                                aria-selected="false">Reviews</a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="synopsis" role="tabpanel" aria-labelledby="synopsis-tab">
                                {!! $product->description !!}
                            </div>
                            <div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                                <table>
                                    <tr>
                                        <td>
                                            <p><b>Brand:</b></p>
                                        </td>
                                        <td>
                                            <p>{{ $product->brand }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p><b>Weight:</b></p>
                                        </td>
                                        <td>
                                            <p>{{ $product->weight }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p><b>Size:</b></p>
                                        </td>
                                        <td>
                                            <p>{{ $product->size }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p><b>Unit of Measurement:</b></p>
                                        </td>
                                        <td>
                                            <p>{{ $product->uom }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p><b>Tags:</b></p>
                                        </td>
                                        <td>
                                            <p>
                                                @forelse($product->tags as $tag)
                                                @if ($loop->last)
                                                {{$tag->tag}}
                                                @else
                                                {{$tag->tag}},&nbsp;
                                                @endif
                                                @empty
                                                @endforelse 
                                            </p>
                                        </td>
                                    </tr>


                                </table>
                            </div>
                            @if(Setting::info()->review_is_allowed > 0)
                            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                @if($product->reviews->count() == 0)
                                <div class="empty-review-wrap">
                                    <img src="{{\URL::to('/')}}/theme/legande/images/misc/comment.png" />
                                    <p>There are no reviews yet.<br />Be the first to review “{{$product->name}}”</p>
                                </div>
                                @else
                                <div class="review-wrap">
                                    @foreach($product->reviews as $review)

                                    <blockquote class="blockquote" style="background-color: white;padding:20px;">
                                        <p class="rating small">{!!$review->ratingStar!!}</p>
                                        <p class="mb-0">{{$review->review}}</p><br>
                                        <footer class="blockquote-footer"><cite title="Source Title">{{$review->user->name}}

                                            <small>({{$review->created_at->diffforhumans()}})</small>

                                        </cite></footer>
                                    </blockquote>

                                    @endforeach
                                </div>
                                @endif
                                <div class="gap-40"></div>
                                @if($sales_history == 1)
                                <div id="review-form">
                                    <div class="form-style-alt">
                                        <h3>We want to know your opinion!</h3>
                                        <label for="rating-count"><b>Your Rating</b></label>
                                        <div class="star-rating">
                                            <span class="fa fa-star-o" data-rating="1"></span>
                                            <span class="fa fa-star-o" data-rating="2"></span>
                                            <span class="fa fa-star-o" data-rating="3"></span>
                                            <span class="fa fa-star-o" data-rating="4"></span>
                                            <span class="fa fa-star-o" data-rating="5"></span>
                                            <input type="hidden" name="rating" id="rating-count" class="rating-value" value="0">
                                        </div>
                                        <div class="gap-20"></div>
                                        <div class="form-wrap">
                                            <textarea id="review-text" class="form-control form-input" name="review-text"></textarea>
                                            <label class="form-label textarea" for="message">Tell us what you thought about it</label>
                                        </div>                                                        

                                    </div>
                                    <div class="gap-20"></div>
                                    <a href="#" onclick="submit_review();" class="btn btn-md primary-btn">Submit</a>
                                </div>
                                @endif
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="gap-80"></div>

            </div>
        </div>
    </div>
</section>


</main>
<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>  
@if((auth()->check()))
<input type="hidden" id="utype" value="{{Auth::user()->user_type}}">
@endif
@endsection

@section('pagejs')

<script src="{{ asset('theme/sysu/plugins/ion.rangeslider/js/ion.rangeSlider.js') }}"></script>
<script src="{{ asset('theme/sysu/plugins/xZoom/src/xzoom.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
    function add_to_cart(product,qty) {
        if($('#'+qty).val() < 1){
            swal({
                title: 'Warning',
                text: 'Please enter item qty.',
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
                $("#loading-overlay").show();
            },
            success: function(returnData) {
                $("#loading-overlay").hide();
                if (returnData['success']) {
                    //$('.cart-counter').html(returnData['totalItems']);
                    swal({
                        toast: true,
                        position: 'center',
                        title: "Product Added to your cart!",
                        type: "success",
                        showCancelButton: true,
                        timerProgressBar: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "View Cart",
                        cancelButtonText: "Continue Shopping",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            window.location.href = "{{route('cart.front.show')}}";
                        } 
                        else {
                            $('#btn'+product).html('<i class="fa fa-cart-plus bg-warning text-light p-1 rounded" title="Already added on cart"></i>');
                            //swal.close();
                            window.location.href = "{{route('product.front.list')}}";
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
        });
    }

    function clear_qty(){
        $('#qty1').val(0);
    }

    function add_to_favorites(product_id){
        $.ajax({
            data: {
                "product_id": product_id,
                "_token": "{{ csrf_token() }}",
            },
            type: "post",
            url: "{{route('btn-add-to-favorites')}}",
            success: function(returnData) {
                if (returnData['success']) {
                    $('#favBtnRemove').css('display','block');
                    $('#favBtnAdd').css('display','none');

                    swal({
                        title: '',
                        text: "Product has been added to favorites.",         
                    });
                }
            }
        });
    }

    function remove_to_favorites(product_id){
        $.ajax({
            data: {
                "product_id": product_id,
                "_token": "{{ csrf_token() }}",
            },
            type: "post",
            url: "{{route('btn-remove-to-favorites')}}",
            success: function(returnData) {
                if (returnData['success']) {
                    $('#favBtnRemove').css('display','none');
                    $('#favBtnAdd').css('display','block');

                    swal({
                        title: '',
                        text: "Product has been removed to favorites.",         
                    });
                }
            }
        });
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
                    $('#wishlistBtnRemove').css('display','block');
                    $('#wishlistBtnAdd').css('display','none');

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
                    $('#wishlistBtnRemove').css('display','none');
                    $('#wishlistBtnAdd').css('display','block');

                    swal({
                        title: '',
                        text: "Product has been removed to wishlit.",         
                    });
                }
            }
        });
    }


    function submit_review()
    {
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            method: "POST",
            url: "{{route('product.review.store')}}",
            data: {
                product_id: {{$product->id}},
                rating: $('#rating-count').val(),
                review: $('#review-text').val(),
                _token: "{{ csrf_token() }}"
            }
        })
        .done(function( html ) {
            //$( "#records" ).html( html );
            $('#review-form').html('<div class="alert alert-primary" role="alert"><h4 class="alert-heading">Success!</h4> Thank you for submitting your review.</div>');
            });
        }
</script>


<script>
    var $star_rating = $('.star-rating .fa');

    var SetRatingStar = function() {
        return $star_rating.each(function() {
            if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    };

    $star_rating.on('click', function() {
        $star_rating.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
    });


    $(document).ready(function() {
        SetRatingStar();
    });
</script>

@endsection
